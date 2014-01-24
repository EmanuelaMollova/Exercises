#include<iostream>
#include<cstring>
using namespace std;

class Vector
{
      public:
        Vector(int);
        ~Vector();

        int getNumber(int) const;
        void setNumber(int);
        int count() const;
        void addNumber(int);
        void removeNumber(int);
        void printVector() const;

      private:
        int* coordinates;
        int n;
};

Vector::Vector(int num)
{
    n = num;
    coordinates = new int[n];
    for(int i = 0; i < n; i++)
    cin >> coordinates[i];
}

Vector::~Vector()
{
    delete [] coordinates;
}

int Vector::getNumber(int index) const
{
    return coordinates[index];
}

void Vector::setNumber(int index)
{
    int newNumber;
    cout << "Replace it with: ";
    cin >> newNumber;
    coordinates[index] = newNumber;
}

int Vector::count() const
{
    return n;
}

void Vector::addNumber(int index)
{
    int add;
    cout << "Add: ";
    cin >> add;
    int* newCoordinates = new int[n+1];
    for(int i = 0; i < index; i++)
    {
        newCoordinates[i] = coordinates[i];
    }
    newCoordinates[index] = add;
    for(int i = index + 1; i < n + 1; i++)
    {
        newCoordinates[i] = coordinates[i - 1];
    }

    delete [] coordinates;
    coordinates = newCoordinates;
    n++;
}

void Vector::removeNumber(int index)
{
    int* newCoordinates = new int[n - 1];
    for(int i = 0; i < index; i++)
    {
        newCoordinates[i] = coordinates[i];
    }

    for(int i = index; i < n - 1; i++)
    {
        newCoordinates[i] = coordinates[i + 1];
    }

    delete [] coordinates;
    coordinates = newCoordinates;
    n--;
}

void Vector::printVector()const
{
    cout << "( ";
    for(int i = 0; i < n - 1; i++)
        cout << coordinates[i] << ", ";

    cout << coordinates[n - 1] << " )";
    cout << endl;
}

void Concat(const Vector& v1, const Vector& v2)
{
     int sum = v1.count() + v2.count();
     int* res = new int[sum];
     for(int i = 0; i < v1.count(); i++)
     {
             res[i] = v1.getNumber(i);
     }


     int p = sum - v2.count();

     for(int i = p; i < sum; i++)
     {
             res[i] = v2.getNumber(i - p);
     }

            cout << "( ";
            for(int i = 0; i < sum - 1; i++)
            cout << res[i] << ", ";
            cout << res[sum - 1] << " )";
            cout << endl;

}

int main()
{
    Vector test(5);
    test.printVector();
    test.removeNumber(3);
    test.printVector();
    cout << test.count();
    cout << endl;
    cout << test.getNumber(1);
    test.setNumber(3);
    test.printVector();
    test.addNumber(5);
    test.printVector();
    Vector b(3);
    b.printVector();
    Concat(test, b);

    system("pause");
    return 0;
}
