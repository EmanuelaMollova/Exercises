class BankBranch
{
    private:
        char* brName;
        SavingsAccount* arr;
        int size;

    public:
        BankBranch(char*);
        ~BankBranch();
        void setBrName(char*);
        char* getBrNmae()const;
        int getAccsNum()const;
        int find(char*);
        double calculateBalance();
};
