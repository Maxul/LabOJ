#include <stdio.h>

int main()
{
    int i, j;
    for (i = -1001; i < 1001; ++i)
        for (j = -100; j < 100; j+=10)
            printf("%d %d\n", i, j);

    return 0;
}
