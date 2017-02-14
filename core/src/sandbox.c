/*
	2016/6/8
	Original Author: Maxul Lee
	<lmy2010lmy@gmail.com>

	Let's say hello and good-bye to the world!
	In this universe of beauty and grace, set
	blank barrier to your forward path.

	To be careful, make sure every system API
	in this file has checked its return value.
*/

#include "common.h"

/* Check whether REG_SYS_CALL(x) is amongst the allowed syscall list */
static int call_is_ok(int syscall)
{
    int i;

    for (i = 0; -1 != strace[i]; ++i)
        if (syscall == strace[i])
            return 1;
    return 0;
}

/* Check whether REG_ARG_1(x) is amongst the legal library list */
static int access_is_ok(const char *file)
{
    int i;

    for (i = 0; ltrace[i]; ++i)
        if (0 == strcmp(file, ltrace[i]))
            return 1;
    return 0;
}

/* wrapper function for resource limit setup */
static void set_resource_limit()
{
    struct rlimit limit;

    limit.rlim_cur = MAX_TIME / 1000;
    limit.rlim_max = MAX_TIME / 1000 + 1;       // second(s)

    if (setrlimit(RLIMIT_CPU, &limit))
        ERR__EXIT(SYSTEM_ERROR, "Set Time Limit Failed");

    limit.rlim_cur = MAX_STACK_SIZE;
    limit.rlim_max = MAX_STACK_SIZE;            // byte(s)

    if (setrlimit(RLIMIT_STACK, &limit))
        ERR__EXIT(SYSTEM_ERROR, "Set Memory Limit Failed");

#if 0
    limit.rlim_cur = MAX_MEMORY * (1 << 20);
    limit.rlim_max = MAX_MEMORY * (1 << 20);	// byte(s)

    /* The maximum size of the process's virtual memory (address space) in bytes */
    if (setrlimit(RLIMIT_AS, &limit))
        ERR__EXIT(SYSTEM_ERROR, "Set Memory Limit Failed");
#endif

}

#define just_kill_it(pid) ptrace(PTRACE_KILL, pid, NULL, NULL)

#define ARRAY_SIZE(x) (sizeof(x) / sizeof((x)[0]))

static int invalid_access(pid_t pid, struct user_regs_struct *registers)
{
    int i;
    long access_file[16];

    /* peek which file this process is opening */
    for (i = 0; i < ARRAY_SIZE(access_file); i++) {
        access_file[i] = ptrace(PTRACE_PEEKDATA,
                                pid,
                                REG_ARG_1(registers) + i * sizeof(long),
                                NULL);
        if (0 == access_file[i])
            break;
    }
    if (!access_is_ok((const char*)access_file)) {
        just_kill_it(pid);
        fprintf(stderr, "INVALID FILE ACCESS \"%s\"\n", (const char*)access_file);
        return 1;
    }
    return 0;
}

int main(int argc, char *argv[], char *env[])
{
    int result = ACCEPTED;
    int status;

    long Time;
    long Memory;

    struct rusage usage;
    struct user_regs_struct regs;

    if (2 != argc)
        ERR_RET(EXIT_FAILURE, "Usage: %s executable\n", argv[0]);

    const char *binary = argv[1];

    pid_t child = fork();

    /* fork a child to monitor(ptrace) its status */
    if (0 == child) {
        set_resource_limit();

        if (ptrace(PTRACE_TRACEME, 0, NULL, NULL))
            ERR__EXIT(SYSTEM_ERROR, "PTRACE_TRACEME Failed");

        if (-1 == execl(binary, "", NULL))
            ERR__EXIT(SYSTEM_ERROR, "execl() Failed");
    }

    /* assure that parent gets executed after child exits */
    if (-1 == child) {
        ERR_RET(SYSTEM_ERROR, "vfork() Failed");
    }

    for (;;) {
        if (-1 == wait4(child, &status, WSTOPPED, &usage))
            ERR_RET(SYSTEM_ERROR, "wait4() Failed");

        /* child has already exited */
        if (WIFEXITED(status)) {
            if (SYSTEM_ERROR == WEXITSTATUS(status))
                return SYSTEM_ERROR;
        }

        if (SIGTRAP != WSTOPSIG(status)) {
            just_kill_it(child);

            switch (WSTOPSIG(status)) {
            case SIGSEGV:
                result = RUNTIME_ERROR;
                //ERR_RET(RUNTIME_ERROR, "SIGSEGV");
                break;
            case SIGALRM:
            case SIGKILL:
            case SIGXCPU:
                result = TIME_LIMIT_EXCEEDED;
                break;
            }
        }

        /* unable to peek register info */
        if (-1 == ptrace(PTRACE_GETREGS, child, NULL, &regs))
            goto END;

        if (!call_is_ok(REG_SYS_CALL(&regs))) {
            just_kill_it(child);
#if 0
            char cmd[1024];
            snprintf(cmd, sizeof(cmd), "grep -E "
                     "'*SYS.*.[[:space:]]%llu$'"
                     " /usr/include/x86_64-linux-musl/bits/syscall.h"
                     " | gawk -F' ' '{print $2}' 1>&2", REG_SYS_CALL(&regs));
            (void)popen(cmd, "r");
#endif
            ERR_RET(RUNTIME_ERROR, "ILLEGAL SYSCALL\n");
        }

        /* watch what the child is going to open */
        if (SYS_open == REG_SYS_CALL(&regs)) {
            if (invalid_access(child, &regs))
                ERR_RET(RUNTIME_ERROR, "INVALID ACCESS\n");
        }

        /* allocate too much from data section */
        if (SYS_writev == REG_SYS_CALL(&regs))
            ERR_RET(MEMORY_LIMIT_EXCEEDED, "ENOMEM on BSS/DATA\n");

        /* trace next system call */
        if (-1 == ptrace(PTRACE_SYSCALL, child, NULL, NULL))
            ERR_RET(SYSTEM_ERROR, "PTRACE_SYSCALL Failed");
    }

END:

    Time = usage.ru_utime.tv_sec * 1000 + usage.ru_utime.tv_usec / 1000
           + usage.ru_stime.tv_sec * 1000 + usage.ru_stime.tv_usec / 1000;
    Memory = usage.ru_maxrss * (sysconf(_SC_PAGESIZE) / 1024) / 1024;

    if (MAX_MEMORY <= Memory)
        result = MEMORY_LIMIT_EXCEEDED;

    if (ACCEPTED == result)
        fprintf(stderr, "TIME: %ldMS MEM: %ldMB\n", Time, Memory);

    return result;
}
