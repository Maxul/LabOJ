# include <stdio.h>
# include <stdlib.h>
# include <time.h>

void gen(int n) {
    while (n--) {
        printf(n == 0 ? "%d\n" : "%d ", rand() % 20 - 5);
    }
}

int main()
{
    srand(time(NULL));

    int time = 3<<14;
    int N, n;
    while (time--) {
        N = rand() % 7 + 4;
        n = N - 3;
        printf("%d %d     ", N, n);
        gen(N);
    }
    return 0;
}
