#include <stdio.h>

static size_t strlen(const char *s);
static int strend(const char *s, const char *t);

static char *strncpy(char *dest, const char *src, size_t n);
static char *strncat(char *dest, const char *src, size_t n);
static int strncmp(const char *s1, const char *s2, size_t n);

static int strcmp(const char *s1, const char *s2) {
    for ( ; *s1 == *s2; s1++, s2++)
        if (*s1 == 0)
            return 0;
    return *s1 - *s2;
}
static void bzero(char *p, size_t n) {
    while (n--)
        *p++ = 0;
}

int main(int argc, char *argv[])
{
    typedef char BUF[1024];

    BUF buf1, buf2;
    char cmd[16];
    size_t n;

    bzero(buf1, sizeof buf1);
    bzero(buf2, sizeof buf2);
    while (1 == scanf("%s", cmd)) {
        if (0 == strcmp("strend", cmd)) {
            scanf("%s%s", buf1, buf2);
            printf("strend: %d\n", strend(buf1, buf2));
        }
        if (0 == strcmp("strncpy", cmd)) {
            scanf("%s%lu", buf2, &n);
            printf("strncpy: %s\n", strncpy(buf1, buf2, n));
        }
        if (0 == strcmp("strncat", cmd)) {
            scanf("%s%lu", buf2, &n);
            printf("strncat: %s\n", strncat(buf1, buf2, n));
        }
        if (0 == strcmp("strncmp", cmd)) {
            scanf("%s%s%lu", buf1, buf2, &n);
            printf("strncmp: %d\n", strncmp(buf1, buf2, n));
        }
    }
    return 0;
}


