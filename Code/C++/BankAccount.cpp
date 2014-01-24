#include<iostream>
using namespace std;

class BankAccount
{
    private:
        char name[24];
        char number[16];
        double sum;

    public:
        void create();
        void write() const;
        void inject(double);
        void withdraw(double);
};

void BankAccount::create()
{
    cout << "Name: ";
    cin >> name;

    cout << "Number: ";
    cin >> number;

    cout << "Sum: ";
    cin >> sum;

    cout << endl;
}

void BankAccount::write() const
{
    cout << name <<" "<< number << endl;
    cout << "Current balance: " << sum << endl;
    cout << endl;
}

void BankAccount::inject (double x)
{
    sum += x;
}

void BankAccount::withdraw (double y)
{
    sum -= y;
}

int main()
{
    BankAccount bank_account;
    bank_account.create();
    bank_account.write();

    cout << "How much will you withdraw?";
    double sum_to_withdraw;
    cin >> sum_to_withdraw;
    bank_account.withdraw(sum_to_withdraw);
    cout << endl;
    bank_account.write();

    cout << "How much will you inject?";
    double sum_to_inject;
    cin >> sum_to_inject;
    bank_account.inject(sum_to_inject);
    cout << endl;
    bank_account.write();

    return 0;
}
