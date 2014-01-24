#include<iostream>
#include<cstring>
#include "SavingsAccount.h"
using namespace std;

double SavingsAccount::percent = 0.5;

SavingsAccount::SavingsAccount(char* num, char* n, double b)
{
    strcpy(number, num);
    name = new char[strlen(n) + 1];
    strcpy(name, n);
    balance = b;
}

SavingsAccount::~SavingsAccount()
{
    delete [] name;
}

void SavingsAccount::setName(char* n)
{
    delete [] name;
    name = new char[strlen(n) + 1];
    strcpy(name, n);
}

void SavingsAccount::setPercent(double p)
{
    if(p < 0 || p > 1)
    {
        cout << "Wrong data!";
    }
    else percent = p;
}

char* SavingsAccount::getNumber()
{
    return number;
}

char* SavingsAccount::getName()const
{
    return name;
}

double SavingsAccount::getPercent()
{
    return percent;
}

bool SavingsAccount::deposit(double addSum)
{
    if(addSum <= 0)
        return false;
    else
    {
        balance += addSum;
        return true;
    }
}

bool SavingsAccount::withdraw(double remSum)
{
    if(remSum <= 0 || remSum > balance)
        return false;
    else
    {
        balance -= remSum;
        return true;
    }
}

double SavingsAccount::getMonthlyInterest()
{
    double interest = balance * percent / 12;
    return interest;
}

void SavingsAccount::print()const
{
    cout << "Number: " << num << " ; Name: " << name << " ; Balance: " << balance << endl;
}

int main()
{
    return 0;
}
