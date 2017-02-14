#include <stdlib.h>
#include <stdio.h>

#define MAXLEN 1000
#define MAXLINES 5000
#define ALLOCSIZE 10000

static char *lineptr[MAXLINES];
static char allocbuf[ALLOCSIZE];
static char *allocp = allocbuf;

static void swap(void **v, int i, int j)
{
    void *temp = v[i];
    v[i] = v[j];
    v[j] = temp;
}

static void strcpy2(char *s, char *t)
{
    while (*s++ = *t++);
}

static int getline2(char s[], int lim)
{
    int c, i;

    for (i = 0; i < lim-1 && (c = getchar()) != EOF && c != '\n'; ++i)
        s[i] = c;
    if (c == '\n')
        s[i++] = c;
    s[i] = '\0';
    return i;
}

static char *alloc(int n)    /* return pointer to n characters */
{
    if (allocbuf + ALLOCSIZE - allocp >= n) { /* it fits */
        allocp += n;
        return allocp - n;  /* old p */
    }
    return 0;
}

static void sort2(void *v[], int left, int right,
                  int (*comp)(void *, void *), int order)
{
    int i, last;

    if (left >= right)    /* do nothing if array contains */
        return;           /* fewer than two elements */
    swap(v, left, (left + right)/2);
    last = left;
    for (i = left+1; i <= right;  i++)
        if (order * (*comp)(v[i], v[left]) < 0)
            swap(v, ++last, i);
    swap(v, left, last);
    sort2(v, left, last-1, comp, order);
    sort2(v, last+1, right, comp, order);
}

int readlines(char *lineptr[], int maxlines)
{
    int len, nlines;
    char *p, line[MAXLEN];

    nlines = 0;
    while ((len = getline2(line, MAXLEN)) > 0)
    {
        if (nlines >= maxlines || (p = alloc(len)) == NULL)
            return -1;
        else {
            line[len-1] = '\0';  /* delete newline */
            strcpy2(p, line);
            lineptr[nlines++] = p;
        }
    }
    return nlines;
}

void writelines(char *lineptr[], int nlines)
{
    while (nlines-- > 0)
        printf("%s\n", *lineptr++);
}

static int numcmp(char *s1, char *s2)
{
    double v1 = atof(s1);
    double v2 = atof(s2);

    return v1 - v2;
}

#define TOUPPER(c) (('a'<=c && c<='z') ? (c+'A'-'a'):(c))

static int strcmp_f(char *s, char *t)
{
    for ( ; TOUPPER(*s) == TOUPPER(*t); s++, t++)
        if (*s == '\0')
            return 0;

    return TOUPPER(*s) - TOUPPER(*t);
}

static int strcmp(char *s, char *t)
{
    for ( ; (*s) == (*t); s++, t++)
        if (*s == '\0')
            return 0;

    return (*s) - (*t);
}

int main(int argc, char *argv[])
{
    int c;
    int nlines;        /* number of input lines read */
    int numeric = 0;   /* 1 if numeric sort */
    int reverse = 0;   /* 1 if sorting in reverse order */
    int foldcase = 0;  /* 1 if sorting case insensitive */

    while (--argc > 0 && (*++argv)[0] == '-') {
        while (c = *++argv[0]) {
            switch (c) {
            case 'n':
                numeric = 1;
                break;
            case 'r':
                reverse = 1;
                break;
            case 'f':
                foldcase = 1;
                break;
            default:
                printf("find: illegal option %c\n", c);
                return -1;
            }
        }
    }

    if ((nlines = readlines(lineptr, MAXLINES)) < 0) {
        printf("input too big to sort\n");
        return 1;
    }
    sort2((void **) lineptr, 0, nlines-1,
          (int (*)(void *, void *))(numeric ? numcmp : (foldcase ? strcmp_f : strcmp)),
          reverse ? -1 : 1);
    writelines(lineptr, nlines);
    return 0;
}

