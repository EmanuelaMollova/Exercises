#include<iostream>
using namespace std;

class Employee
{
        private:
            struct
            {
                char first[30];
                char last[30];
            }name;

            struct
            {
                double hours;
                double salary;
            }work;

        public:
            void read();
            void write() const;
};

void Employee::read()
{
    cout << "First name" << endl;
    cin >> name.first;

    cout << "Last name" << endl;
    cin >> name.last;

    cout << "Hours" << endl;
    cin >> work.hours;

    cout << "Salary per hour" << endl;
    cin >> work.salary;
}

void Employee::write() const
{
    cout << name.first << " " << name.last << endl;
    cout << work.hours << " hours x " << work.salary << "salary = " <<  work.hours * work.salary  << endl;
    cout << endl;
}

int main ()
{
    Employee employee;
    employee.read();
    employee.write();
    return 0;
}
