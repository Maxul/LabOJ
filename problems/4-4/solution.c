/*
请仔细阅读源代码，完成整体程序的编写。
*/

/* 头文件 */
#include <stdlib.h>
#include <string.h>
#include <stdio.h>

/*
本用例是对栈模型的一个简单扩充，
关于栈的具体数学知识，请参见维基百科
https://en.wikipedia.org/wiki/Stack_(abstract_data_type)
*/

/* 设置栈的最大深度 */
#define MAXVAL 100

int sp = 0;          /* 下一空闲栈位置 */
double val[MAXVAL];  /* 双精度值栈 */

/* 函数原型声明如下 */

/* 将数据压入栈顶 */
void push(double val);
/* 取走栈顶元素 */
double pop(void);
/* 查看栈顶元素 */
void top(void);
/* 复制栈顶元素，即栈顶头两个元素相同 */
void duplicate(void);
/* 交换栈顶端的两个元素 */
void swaps(void);
/* 清空栈 */
void clear(void);

int main()
{
    double value;
    char str[1024];

    while (1 == fscanf(stdin, "%s", str))
    {
        if (0 == strcmp(str, "push")) {
            if (1 == scanf("%lf", &value))
                push(value);
        } else if (0 == strcmp(str, "pop")) {
            pop();
        }  else if (0 == strcmp(str, "top")) {
            top();
        }  else if (0 == strcmp(str, "duplicate")) {
            duplicate();
        }  else if (0 == strcmp(str, "swaps")) {
            swaps();
        }  else if (0 == strcmp(str, "clear")) {
            clear();
        }
    }
    return EXIT_SUCCESS;
}

/* 在栈还有空间时压入，否则报错："Stack is full!" */
void push(double f)
{
    if(sp < MAXVAL)
        val[sp++] = f;
    else
        printf("Stack is full!\n");
}

/* 存在栈顶元素时返回该值，否则报错："Stack is empty!" */
double pop(void)
{
    if(sp > 0)
        return val[--sp];
    else
    {
        printf("Stack is empty!\n");
        return 0.0;
    }
}

/* 存在栈顶元素时将其直接打印，但不弹出，否则报错："Stack is empty!" */
void top(void)
{
    if(sp > 0)
        printf("%lf\n", val[sp-1]);
    else
        printf("Stack is empty!\n");
}

/* 存在栈顶元素时增加与栈顶相同的元素，否则报错："Stack is empty!" */
void duplicate(void)
{
    double top;

    if (sp > 0) {
        top = pop();

        push(top);
        push(top);
    }
    else
        printf("Stack is empty!\n");

}

/* 栈顶存在两个元素时交换位置，否则报错："Swap failed!" */
void swaps(void)
{
    double item1, item2;

    if (sp > 1) {
        item1 = pop();
        item2 = pop();

        push(item1);
        push(item2);
    }
    else
        printf("Swap failed!\n");
}

/* 清空栈内所有元素，并打印："Stack is now empty!" */
void clear(void)
{
    sp = 0;
    printf("Stack is now empty!\n");
}

