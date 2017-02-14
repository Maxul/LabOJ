#include <stdio.h>

void reverse_printf(char s[]);

int main()
{
    char string[1024];
    int index;
    int ch;

    index = 0;
    while ((ch = getchar()) != '\n')
        string[index++] = ch;
    string[index] = '\0';

    reverse_printf(string);
    return 0;
}

void reverse_printf(char s[])
{
    int i;

    /* count the length */
    for (i=0; s[i]; ++i);

    /* print the string in reverse order */
    for (--i; i>=0; --i)
        putchar(s[i]);

    /* in case of presentation error */
    putchar('\n');
}

