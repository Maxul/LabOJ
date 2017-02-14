/* 我不会scanf，printf的实现，所以请来了头文件 */
#include <stdio.h>
#include <string.h>

/* 我把二进制字符串转化成十进制整型数，相加再转回去… */
int binary_to_decimal(char s[]);
void print_decimal_in_binary(int n);

/* 不知什么时候起，写主函数成了c, c++, java码农的习惯 */
int main()
{
    int a, b;
    // 认真查询了文档，scanf返回成功输入的数据个数
    while (scanf("%x%x", &a, &b)  == 2) {
        print_decimal_in_binary(a + b);
    }
    return 0;
}

void print_decimal_in_binary(int n) {
    /* 接下来的算法我不写注释，请自行脑补…… */
    char s[32];
    int i = 0;

    memset(s, 0, sizeof s);

    do {
        s[i++] = '0' + (n & 1);
        n >>= 1;
    } while (n);
    while (--i >= 0) {
        putchar(s[i]);
    }
    putchar('\n');  // 千万记得换行，要不然会导致格式问题！
}
/* 大功告成！ */
