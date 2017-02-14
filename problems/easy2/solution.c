#include <stdio.h>

int main()
{
    int a, b;

    while (scanf("%d %d", &a, &b) == 2) {
        if (b == 0)
            printf("undefined\n");
        else
            printf("%d\n", a%b);
    }

    return 0;
}
