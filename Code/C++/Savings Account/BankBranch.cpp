#include<iostream>
#include<cstring>
#include "BankBranch.h"
#include "SavingsAccount.cpp"
using namespace std;

BankBranch::BankBranch(char* n)
{
    brName = new char[(strlen(n) + 1)];
    strcpy(brName, n);
    size = 0;
}

BankBranch::~BankBranch()
{
    delete [] brName;
    delete [] arr;
}

void BankBranch::setName(char* n)
{
    delete [] brName;
    brName = new char[strlen(n) + 1];
    strcpy(brName, n);
}

char* BankBranch::getBrName()const
{
    return brName;
}

int BankBranch::getAccsNum()const
{
    return size;
}

int BankBranch::find(char* a)
{
    int i =- 1;
    do
    {
        i++;
    } while(i < size && strcmp(a, arr[i].number) != 0)

    if(i == size)
    return - 1;
    else
    {
        return i - 1;
    }
}

double BankBranch::calculateBalance()
{
    int total = 0;
    for(int i = 0; i < size; i++)
    {
        total = total + arr[i].balance;
    }
    return total / size;
}
