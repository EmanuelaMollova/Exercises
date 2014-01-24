#include<iostream>

using namespace std;

class IntSet
{
    friend bool operator < (const IntSet&, const IntSet&);

    public:
        IntSet(int = 0);
        ~IntSet();
        IntSet(const IntSet&);
        IntSet& operator = (const IntSet&);

        void readSet();
        void printIntSet() const;
        int count() const;

        IntSet operator + (const IntSet&); // union
        void operator + (int); // adds element to the set
        IntSet operator - (const IntSet&); // relative complement
        void operator - (int); // removes element if it exists
        IntSet operator * (const IntSet&); // intersection
        IntSet operator ^ (const IntSet&); // symmetric difference
        bool operator == (const IntSet&);
        IntSet operator ! (); // complement

        bool exists (int) const;
        void toString (char*);

        IntSet& operator += (const IntSet&);
        IntSet& operator -= (const IntSet&);
        IntSet& operator *= (const IntSet&);
        IntSet& operator ^= (const IntSet&);
        IntSet& operator != (IntSet&);

    private:
        int* set;
        int n;
        void copy(const IntSet&);
};

IntSet::IntSet(int num)
{
    n = num;
    set = new int[n];
    for(int i = 0; i < n; i++)
    set[i] = 0;
}

IntSet::~IntSet()
{
    delete [] set;
}

void IntSet::copy(const IntSet& r)
{
    set = new int[r.n];
    for(int i = 0; i < r.n; i++)
    {
        set[i] = r.set[i];
    }
    n = r.n;
}

IntSet::IntSet(const IntSet& p)
{
    copy(p);
}

IntSet& IntSet::operator = (const IntSet& q)
{
    if(this != &q)
    {
        delete [] set;
        copy(q);
    }
    return *this;
}

void IntSet::readSet()
{
    for(int i = 0; i < n; i++)
    {
        cin >> set[i];
    }
}

int IntSet::count() const
{
    return n;
}

void IntSet::printIntSet()const
{
    cout << "[ ";
    for(int i = 0; i < n - 1; i++)
    cout << set[i] << ", ";

    cout << set[n - 1] << " ]";
    cout << endl;
}

IntSet IntSet:: operator + (const IntSet& set1)
{
    IntSet res(n + set1.n);
    for(int i = 0; i < n; i++)
    {
        res.set[i] = set[i];
    }
    for(int i = n; i < n + set1.n; i++)
    {
        if(exists(set1.set[i - n])) res.set[i] = 0;
        else res.set[i] = set1.set[i - n];
    }
    res - 0;
    return res;
}

void IntSet::operator + (int number)
{
    int* newset = new int[n + 1];
    for(int i = 0; i < n; i++)
    {
        newset[i] = set[i];
    }
    newset[n] = number;
    set = newset;
    n++;
}

IntSet IntSet::operator - (const IntSet& set1)
{

    IntSet res = *this;
    for(int i = 0; i < set1.n; i++)
    {
        if(exists(set1.set[i])) res - set1.set[i];
    }

    return res;
}

void IntSet::operator - (int number)
{
    do
    {
        for(int i = 0; i < n; i++)
        {
            if(set[i] == number)
            {
                int k = i;
                int* newset = new int[n - 1];
                for(int j = 0; j < k; j++)
                newset[j] = set[j];
                for(int j = k + 1; j < n; j++)
                newset[j - 1] = set[j];
                set = newset;
                n--;
            }

        }
    }while(exists(number));
    //if(n == 0) cout << "There are no elements in the array!\n";

}

IntSet IntSet:: operator * (const IntSet& set1)
{
    IntSet res(n);
    for(int i = 0; i < n; i++)
    {
        if(exists(set1.set[i])) res.set[i] = set1.set[i];
        else res.set[i] = 0;
    }
    res - 0;
    //if(res.n == 0) cout << "The sets don't have common elements!\n";

    return res;
}

IntSet IntSet:: operator ^ (const IntSet& set1)
{
    IntSet res(n + set1.n);
    res = (*this + set1) - (*this * set1);
    return res;
}

bool IntSet:: operator == (const IntSet& set1)
{
    if(n != set1.n) return false;
    for(int i = 0; i < n; i++)
    {
        if(set[i] != set1.set[i]) return false;
    }
    return true;
}

IntSet IntSet::operator ! ()
{
    IntSet base(20);
    for(int i = 0; i < 20; i++)
    {
        base.set[i] = i + 1;
    }
    int j =- 1;
    for(int i = 0; i < 20; i++)
    {
        j++;
        if(exists(base.set[j]))
        {
            base - base.set[j];
            j--;
        }
    }
    return base;
}

bool IntSet::exists(int a) const
{
    for(int i = 0; i < n; i++)
    {
        if(a == set[i]) return true;
    }
    return false;
}

void IntSet::toString(char* buffer)
{
    int min;
    for(int i = 0; i < n - 1; i++)
    {
        int k = i;
        min = set[i];
        for(int j = i + 1; j < n; j++)
        {
            if(set[j] < min)
            {
                min = set[j];
                k = j;
            }
        }
        min = set[i];
        set[i] = set[k];
        set[k] = min;
    }

    int p = n + (n - 1) * 2 - 1;
    for(int i = 0; i < p; i = i + 3)
    {
        buffer[i] = (char)set[i / 3] + '0';
        buffer[i + 1] = ',';
        buffer[i + 2] = ' ';
    }
    buffer[p] = set[n - 1] + '0';
    buffer[p + 1] = '\0';
}

bool operator < (const IntSet& p1, const IntSet& p2)
{
    if(p1.n > p2.n) return false;
    int br = 0;
    for(int i = 0; i < p2.n; i++)
    {
        for(int j = 0; j < p1.n; j++)
        {
            if(p1.set[j] == p2.set[i]) br++;
        }
    }
    if(br == p1.n) return true;
    else return false;
}

IntSet& IntSet:: operator += (const IntSet& s)
{
    return *this = *this + s;
}

IntSet& IntSet:: operator -= (const IntSet& s)
{
    return *this = *this - s;
}

IntSet& IntSet:: operator *= (const IntSet& s)
{
    return *this = *this * s;
}

IntSet& IntSet:: operator ^= (const IntSet& s)
{
    return *this = *this ^ s;
}

IntSet& IntSet:: operator != (IntSet& s)
{
    return *this = !s;
}

char toChar(int a)
{
    int p = a;
    int br = 0;
    do
    {
       p /= 10;
       br++;
    } while(p > 0);

    char* res = new char[br];
    for(int i = br - 1; i >= 0; i--)
    {
        res[i] = char(a % 10) + '0';
        a /= 10;
    }

    return* res;
}

int main ()
{
    IntSet test(5);
    test.readSet();
    char* a = new char[test.count() + (test.count() - 1) * 2 + 1];
    test.toString(a);
    cout << a;

    return 0;
}
