/*
	2016/6/8
	Original Author: Maxul Lee
	<lmy2010lmy@gmail.com>
*/

#include "common.h"

static int compare(const char *s1, const char *s2)
{
    /* test if the same */
    while (*s1 && *s1 == *s2) {
        ++s1;
        ++s2;
    }

    /* both encounter NUL */
    if (!(*s1 || *s2))
        return ACCEPTED;

    for (;;) {
        /* skip invisible characters */
        while (isspace(*s1))
            s1++;
        while (isspace(*s2))
            s2++;
        /* either is NUL, no need to compare more */
        if (!(*s1 && *s2))
            break;
        /* neither is NUL */
        if (*s1 != *s2)
            return WRONG_ANWSER;
        /* keep running */
        ++s1;
        ++s2;
    }
    return (*s1 || *s2) ? WRONG_ANWSER : PRESENTATION_ERROR;
}

/*
	When the tested source file has been compiled and
	successfully produced the output file, this function
	will perform the answer checking exercise.
*/

int main(int argc, char *argv[], char *env[])
{
    int result = ACCEPTED;

    int fd[2];

    char *out_mem, *tmp_mem;
    off_t out_len, tmp_len;

    const char *out_file = argv[1];
    const char *tmp_file = argv[2];

    if (3 != argc)
        ERR_RET(EXIT_FAILURE, "Usage: %s out_file temp_file\n", argv[0]);

    if ((fd[0] = open(out_file, O_RDONLY, 0644)) < 0)
        ERR_RET(SYSTEM_ERROR, "open(out_file) Failed");

    if ((fd[1] = open(tmp_file, O_RDONLY, 0644)) < 0)
        ERR_RET(SYSTEM_ERROR, "open(tmp_file) Failed");

    /* collect length infomation */
    out_len = lseek(fd[0], 0, SEEK_END);
    tmp_len = lseek(fd[1], 0, SEEK_END);

    if (-1 == out_len || -1 == tmp_len)
        ERR_RET(SYSTEM_ERROR, "lseek() Failed");

    /* compare them according to their size */
    if (MAX_OUTPUT <= tmp_len)
        return OUTPUT_LIMIT_EXCEEDED;

    /* both are empty */
    if (0 == (out_len || tmp_len))
        return ACCEPTED;
    /* either is empty */
    if (0 == (out_len && tmp_len))
        return WRONG_ANWSER;

    /* rewind */
    lseek(fd[0], 0, SEEK_SET);
    lseek(fd[1], 0, SEEK_SET);

    if (-1 == out_len || -1 == tmp_len)
        ERR_RET(SYSTEM_ERROR, "lseek() or rewind Failed");

    /* map files to memory for efficiency */
    if ((out_mem = mmap(NULL, out_len, PROT_READ, MAP_PRIVATE, fd[0], 0)) == MAP_FAILED)
        ERR_RET(SYSTEM_ERROR, "mmap(out_mem) Failed");
    if ((tmp_mem = mmap(NULL, tmp_len, PROT_READ, MAP_PRIVATE, fd[1], 0)) == MAP_FAILED)
        ERR_RET(SYSTEM_ERROR, "mmap(tmp_mem) Failed");

    result = compare(out_mem, tmp_mem);

    /* clean */
    if (-1 == munmap(out_mem, out_len) || -1 == munmap(tmp_mem, tmp_len))
        ERR_RET(SYSTEM_ERROR, "munmap() Failed");

    /* in case of running out of available file descriptors */
    if (-1 == close(fd[0]) || -1 == close(fd[1]))
        ERR_RET(SYSTEM_ERROR, "close(fd[]) Failed");

    return result;
}

