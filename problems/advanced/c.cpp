#include <iostream>
using namespace std;
struct foo1 {
	char *p;
	long long l;
	char x;
};
struct foo2 {
	char *p[11];
	char c;
};
struct foo5 {
	int x;
	char pad[0];
	char c[15];
	double d;
};
struct foo6
{
	int *(*p[2])[10];
};
struct foo3 {
        short s;
        char c;
};
struct foo4 {
        char c;
        char **argv;
        short x;
};
int main(int argc, char *argv[])
{
	cout << sizeof(foo1) << endl;
	cout << sizeof(foo2) << endl;
	cout << sizeof(foo3) << endl;
	cout << sizeof(foo4) << endl;
	cout << sizeof(foo5) << endl;
	cout << sizeof(foo6) << endl;
	return 0;
}
