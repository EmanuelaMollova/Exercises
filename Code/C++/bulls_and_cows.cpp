#include <cstdlib>
#include <ctime>
#include <iostream>

using namespace std;

int main ()
{
    int numbers[15] = {1234, 2376, 9642, 8651, 7604, 3870, 6041, 3564, 6745, 5437, 1324, 6741, 4578, 9071, 7831};
    srand (time(NULL));
    int number_index = rand() % 15;
    int b[4];
    int c[4];

    do
    {
        for(int i = 3; i >= 0; i--)
        {
            b[i] = numbers[number_index] % 10;
            numbers[number_index] /= 10;
        }
    } while(numbers[number_index] != 0);

    cout << "This is the game bulls and cows. Your goal is to find the number, chosen by the computer with minimal";
    cout << "count of questions. The number has 4 digits, which are different and it doesn't start with 0. If your";
    cout << "suggested number has a number, which is the same and on the same position as in the original number,";
    cout << "you have a bull, and if the position is different - you have a cow. Enjoy the game!\n";
    cout << endl;
    cout << endl;

    int n;
    cout << endl;

    int bulls = 0; int cows = 0;

    do
    {
        cout << "Give you guess: ";
        cin >> n;

        do
        {
            for(int i = 3; i >= 0; i--)
            {
                c[i] = n % 10;
                n /= 10;
            }
        } while(n != 0);

		bulls = 0;
		for(int i = 0; i < 4; i++)
		{
			if(b[i] == c[i])
				bulls++;
		}

		cout << endl;

		if(bulls != 0 && bulls != 4)
			cout << "You have " << bulls << " bull(s).";

		if(bulls == 4)
			cout << "Congratulations! You guessed the number\n";

		cows = 0;
		for(int i = 0; i < 4; i++)
		{
			for(int j = 0; j < 4; j++)
				if(b[i] == c[j]) cows++;
		}

		cout << endl;

		if(cows - bulls != 0)
			cout << "You have " << cows - bulls << "cow(s).\n";

		if(bulls == 0 && cows == 0)
			cout << "Try again!\n";

		cout << endl;
		cout << endl;
    } while (bulls != 4);

    return 0;
}
