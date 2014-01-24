class SavingsAccount
{
    private:
        char number[17];
        char * name;
        static double percent;
        double balance;

    public:
        SavingsAccount(char* , char*, double = 0);
        ~SavingsAccount();
        void setName(char *);
        static void setPercent(double);
        char* getNumber();
        char* getName()const;
        static double getPercent();
        bool deposit(double);
        bool withdraw(double);
        double getMonthlyInterest();
        void print()const;
};


