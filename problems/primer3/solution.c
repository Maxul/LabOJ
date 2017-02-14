/*
y = k * x + b
Yes: k1 != k2 || (k1 == k2 && b1 == b2)
No: k1 == k2 && b1 != b2
Note that k might not exist
*/

#include <stdio.h>
#include <limits.h>

const double EPSILON = 1e-5;
double k1, k2, b1, b2;
static int x1[2], y1[2], x2[2], y2[2];

double abs_diff(double a, double b) {
    return (a > b) ? a - b : b - a;
}

int main()
{
    while (8 == scanf("%d%d%d%d %d%d%d%d",
                      &x1[0], &y1[0], &x1[1], &y1[1], &x2[0], &y2[0], &x2[1], &y2[1]))
    {
        k1 = (double)(y1[0]-y1[1])/(x1[0]-x1[1]);
        k2 = (double)(y2[0]-y2[1])/(x2[0]-x2[1]);
        b1 = y1[0] - k1 * x1[0];
        b2 = y2[0] - k2 * x2[0];
//		printf("%lf %lf %lf %lf\n", k1, k2, b1, b2);
        if (x1[0] == x1[1] && x2[0] == x2[1]) {
            if (x1[0] != x2[0])
                printf("No\n");
            else
                printf("Yes\n");
            continue;
        }
        if (k1 - k2 < EPSILON && abs_diff(b1, b2) > EPSILON)
            printf("No\n");
        else
            printf("Yes\n");
    }
    return 0;
}

