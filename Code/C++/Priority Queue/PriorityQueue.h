template <class T=int>
class PriorityQueue
{
    private:
        T* a;
        int size;
        void copy(const PriorityQueue&);

    public:
        PriorityQueue();
        ~PriorityQueue();
        PriorityQueue(const PriorityQueue&);
        PriorityQueue& operator=(const PriorityQueue&);

        bool isEmpty();
        void push(T add);
        void pop();
        T top();
        int getCount();
        void print();
};
