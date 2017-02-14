#include <stdio.h>

int main()
{
    int matrix[10][10];
    int col, row;
    int i, j;

    scanf("%d %d", &row, &col);

    for (i=0; i<row; i++)
        for (j=0; j<col; j++)
            scanf("%d", &matrix[i][j]);

    for (j=0; j<col; j++)
        for (i=0; i<row; i++) {
            if (i == row-1)
                printf("%d\n", matrix[i][j]);
            else
                printf("%d ", matrix[i][j]);
        }
    return 0;
}

