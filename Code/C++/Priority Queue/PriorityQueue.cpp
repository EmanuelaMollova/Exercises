#include<iostream>
#include<cstring>
#include "PriorityQueue.h"
using namespace std;

template <class T>
PriorityQueue<T>::PriorityQueue()
{
    size = 0;
}

template <class T>
PriorityQueue<T>::~PriorityQueue()
{
    delete [] a;
}

template <class T>
void PriorityQueue<T>::copy(const PriorityQueue<T>& c)
{
    size = c.size;
    a = new T[c.size];
    for(int i = 0; i < c.size; i++)
    {
        a[i] = c.a[i];
    }
}

template <class T>
PriorityQueue<T>::PriorityQueue(const PriorityQueue<T>& p)
{
    copy(p);
}

template <class T>
PriorityQueue<T>& PriorityQueue<T>::operator= (const PriorityQueue<T>& r)
{
    if(this != &r)
    {
        delete [] a;
        copy(r);
    }
    return *this;
}

template <class T>
bool PriorityQueue<T>::isEmpty()
{
    return size == 0;
}

template <class T>
void PriorityQueue<T>::push(T add)
{
    if(isEmpty())
    {
        a = new T[1];
        a[0] = add;
        size++;
    }
    else
    {
        PriorityQueue tmp = *this;
        int i = -1;
        do
        {
            ++i;
        } while(i < tmp.size && tmp.a[i] < add );

        if(i >= tmp.size)
        {
            delete [] a;
            a = new T[tmp.size + 1];
            for(int i = 0; i < tmp.size; i++)
            {
                a[i] = tmp.a[i];
            }
            a[tmp.size] = add;
        }
        else if(tmp.a[i] > add)
        {
            delete [] a;
            a = new T[tmp.size + 1];
            for(int j = 0; j < i; j++)
            {
                a[j] = tmp.a[j];
            }
            a[i] = add;
            for(int s = i + 1; s < tmp.size + 1; s++)
            {
                a[s] = tmp.a[s - 1];
            }
        }
        size++;
    }
}

template <class T>
void PriorityQueue<T>::pop()
{
    PriorityQueue p;
    p = *this;
    delete [] a;
    a = new T[size - 1];
    for(int i = 0; i < size - 1; i++)
    {
        a[i] = p.a[i];
    }
    size--;
}

template <class T>
T PriorityQueue<T>::top()
{
    return a[size - 1];
}

template <class T>
int PriorityQueue<T>::getCount()
{
    return size;
}

template <class T>
void PriorityQueue<T>::print()
{
    for(int i = 0; i < size; i++)
    {
        cout << a[i] << " ";
    }
}

int main()
{

    return 0;
}
