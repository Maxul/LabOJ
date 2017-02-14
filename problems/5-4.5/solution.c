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
            scanf("%s%u", buf2, &n);
            printf("strncpy: %s\n", strncpy(buf1, buf2, n));
        }
        if (0 == strcmp("strncat", cmd)) {
            scanf("%s%u", buf2, &n);
            printf("strncat: %s\n", strncat(buf1, buf2, n));
        }
        if (0 == strcmp("strncmp", cmd)) {
            scanf("%s%s%u", buf1, buf2, &n);
            printf("strncmp: %d\n", strncmp(buf1, buf2, n));
        }
    }
    return 0;
}

static size_t strlen(const char *s) {
    size_t len = 0;

    while (s[len++]);
    return len;
}

static int strncmp(const char *s1, const char *s2, size_t n) {
    for ( ; n--; ++s1, ++s2) {
        if (*s1 != *s2)
            return *s1 - *s2;
    }
    return 0;
}
static char *strncat(char *dest, const char *src, size_t n) {
    char *p = dest;

    while (*p)
        p++;
    while (n-- && *src)
        *p++ = *src++;
    *p = '\0';
    return dest;
}
static char *strncpy(char *dest, const char *src, size_t n) {
    char *p = dest;

    while (n-- && *src)
        *p++ = *src++;
    *p = '\0';
    return dest;
}
static int strend(const char *s, const char *t) {
    s += (strlen(s) - strlen(t)); //increments to the point of comparison
    while (*s++ == *t++)          //tests for equality
        if (*s == '\0')           //checks for null character while lines are equal
            return 1;
    return 0;
}

