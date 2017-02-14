#include <stdio.h>

int main() {
    int a, b;
    int num = 0xfffff;

    while (2 == scanf("%d%d", &a, &b))
        printf("%d\n", a+b);

    while (num--)
        printf("%d\n", a+b);

    return 0;
}
