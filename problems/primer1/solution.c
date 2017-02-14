#include <stdio.h>

void word(char *s) {
    while (*s && *s != ' ')
        putchar(*s++);
}

void rev(char *s) {
    int i = 0;

    while (s[i] != '\n') i++;
    s[i] = '\0';

    while (1) {
        while (s[i-1] != ' ') i--;
        if (i < 0) break;
        word(s+i);
        i--;
        printf(" ");
    }
    word(s);
    printf("\n");
}

int main()
{
    char s[1024];

    while (NULL != fgets(s, sizeof(s), stdin)) {
        rev(s);
    }
    return 0;
}

