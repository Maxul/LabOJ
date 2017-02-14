#include <stdio.h>
#include <limits.h>

static long long chosen, product;
long long array[1024], option[1024];

void calc_prod(int n) {
    int i, prod = 1;
    for (i = 0; i < n; i++)
        prod *= option[i];
    if (prod < product)
        product = prod; // 记下当前最小乘积
}

void fn(int left, int right, int remain, int pos) {
    int i;

    if (remain == 1) {
        for (i = left; i < right; ++i) {
            option[pos] = array[i];
            calc_prod(chosen); // 已选好一轮，计算乘积
        }
    } else {
        for (i = left; i < right; ++i) {
            option[pos] = array[i];
            fn(i + 1, right + 1, remain - 1, pos + 1); // 区间右移，剩余递归
        }
    }
}

int main()
{
    int N, n;
    int i;

    while (2 == scanf("%d %d", &N, &n)) {
        for (i = 0; i < N; i++)
            scanf("%lld", &array[i]);
        chosen = n;
        product = INT_MAX; // 初始化为最大值
        fn(0, N + 1 - n, n, 0);
        printf("%lld\n", product);
    }
    return 0;
}

