#include <stdio.h>

int h, m, s;
int secs[2];

int to_sec() {
    return h*3600 + m*60 + s;
}

void calc() {
    int diff = secs[1] - secs[0];
    if (diff < 0) diff = 3600*24 + diff;
    h = diff / 3600;
    diff %= 3600;
    m = diff / 60;
    diff %= 60;
    s = diff;
    printf("%d:%d:%d\n", h, m, s);
}

int main()
{
    while (scanf("%d:%d:%d", &h, &m, &s) == 3) {
        secs[0] = to_sec();
        scanf("%d:%d:%d", &h, &m, &s);
        secs[1] = to_sec();
        calc();
    }
    return 0;
}

