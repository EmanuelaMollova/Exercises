[Learn VimScript the Hard Way](http://learnvimscriptthehardway.stevelosh.com/)

- :echo - just echos
- :echom - echoes and writes the message to messages
- :messages

There are two main kinds of options:
 - boolean options (either "on" or "off")
 - options that take a value.

Boolean options
---------------

	set number (on)
	set nonumber (off)

 Toggling - :set number!
 Check if on or off - :set number?

Options with Values
-------------------

	set <name>=<value>
	set <name>?

Interesting options:

echo, echom, messages, number, numberwidth, wrap, shiftround, matchtime,
relativenumber

Mappings
--------

 - nmap - normal mode
 - vmap - visual mode
 - imap - insert mode

Remove mapping: `*unmap <mapping>`

All of these has another version - *map -> *noremap
Use the second version always!!!

	let mapleader = ...
	let maplocalleader = ...

	map <Leader>...

	iabbrev adn and
	iabbrev @ email@emai.com

**<C-t>** - indent
**<C-d>** - unindent

H - go to the top of page
L - go to the bottom of page

When you map something with <Nop>, it doesn't do anything any more!

For mapping only for the current window (buffer):

`:nnoremap <buffer> <leader>x dd`
In this is case it's best to use <localleader>.

Set on option only for the current window (buffer):
:setlocal number

The local options, mappings, ... have higher priority.

Autocommands
------------

    autocmd BufNewFile * :write
    autocmd BufWritePre,BufRead *.html :normal gg=G

    autocmd FileType javascript nnoremap <buffer> <localleader>c I//<esc>
    autocmd FileType python     nnoremap <buffer> <localleader>c I#<esc>

Autocommands and Abbreviations
------------------------------

    autocmd FileType python     :iabbrev <buffer> iff if:<left>
    autocmd FileType javascript :iabbrev <buffer> iff if ()<left>

Groups
------

    augroup filetype_html
        autocmd!
        autocmd FileType html nnoremap <buffer> <localleader>f Vatzf
    augroup END

If you want to clear a group you can use autocmd! inside the group.

An operator is a command that waits for you to enter a movement command, and
then does something on the text between where you currently are and where the
movement would take you. Some examples of operators are d, y, and c.

Operator-Pending Mappings
-------------------------

    onoremap p i(
    onoremap in( :<c-u>normal! f(vi(<cr> - do something in the next ()

    onoremap ih :<c-u>execute "normal! ?^==\\+$\r:nohlsearch\rkvg_"<cr>

Help for regex - **:help pattern-overview**, also :help normal, execute, expr-quote

za - to fold/unfold

In the vimscript file to fold/unfold a block, surround it in:

	" Block title -------------------------------- {{{
	block
	" }}}

Variables
---------

- Defining

		let foo = "bar"
		echo foo

- Options as variables

		set textwidth=80
		echo &textwidth

		set nowrap
		echo &wrap

		set wrap
		echo &wrap

		let &textwidth = 100
		set textwidth?

		let &textwidth = &textwidth + 10
		set textwidth?

- Registers as Variables

		let @a = "hello!"

		echo @a

		echo @"

Vim will echo the word you just yanked. The " register is the "unnamed" register,
which is where text you yank without specifying a destination will go.

Perform a search in your file with /someword, then run the following command:

	echo @/

Vim will echo the search pattern you just used. This lets you programmatically
read and modify the current search pattern, which can be very useful at times.

- Variable Scoping

Open two different files in separate splits, then go into one of them and run
the following commands:

	let b:hello = "world"
	echo b:hello

As expected, Vim displays world. Now switch to the other buffer and run the echo
command again:

    echo b:hello

This time Vim throws an error, saying it can't find the variable.
When we used b: in the variable name we told Vim that the variable hello should
be local to the current buffer.

Multiple-Line Statements can be separated with `|` and will be treaten as separate
commands.

Conditions
----------

    if 0
        echom "if"
    elseif "nope!"
        echom "elseif"
    else
        echom "finally!"
    endif

Strings starting with letters are converted to 0 => false.

Strings begining with numbers are converted to that number:

    "10hello" => 10

**The behavior of == depends on a user's settings.**

- **==?** is the "case-insensitive no matter what the user has set" comparison
  operator

- **==#** is the "case-sensitive no matter what the user has set" comparison
operator

**Vimscript functions must start with a capital letter if they are unscoped!**

If there is no `return` in a function, it will return 0.

When you write a Vimscript function that takes arguments you always need to
prefix those arguments with a: when you use them to tell Vim that they're in the
argument scope.

    function DisplayName(name)
    echom "Hello!  My name is:"
    echom a:name
    endfunction

Varargs
-------

Vimscript functions can optionally take variable-length argument lists.

    function Varg(...)
    echom a:0      " 2
    echom a:1      " a
    echo a:000     " ['a', 'b']
    endfunction

    call Varg("a", "b")

The `...` in the function definition tells Vim that this function can take any
number of arguments.

The first line of the function echoes the message a:0 and displays 2. When you
define a function that takes a variable number of arguments in Vim, a:0 will be
set to the number of extra arguments you were given. In this case we passed two
arguments to Varg so Vim displayed 2.

The second line echoes a:1 which displays a. You can use a:1, a:2, etc to refer
to each extra argument your function receives. If we had used a:2 Vim would have
displayed "b".

The third line is a bit trickier. When a function has varargs, a:000 will be set
to a list containing all the extra arguments that were passed. We haven't looked
at lists quite yet, so don't worry about this too much. You can't use echom with
a list, which is why we used echo instead for that line.

You can use varargs together with regular arguments too.

    function Varg2(foo, ...)
    echom a:foo      " a
    echom a:0        " 2
    echom a:1        " b
    echo a:000       " ['b', 'c']
    endfunction

    call Varg2("a", "b", "c")

`.` is the "concatenate strings" operator in Vim, which lets you combine strings.

Literal Strings
---------------

Vim also lets you use "literal strings" to avoid excessive use of escape sequences.

    :echom '\n\\'

Vim displays \n\\. Using single quotes tells Vim that you want the string exactly
as-is, with no escape sequences. The one exception is that two single quotes in a
row will produce one single quote.

    :echom 'That''s enough.'

Vim will display `That's enough.`. Two single quotes is the only sequence that has
special meaning in a literal string.

Some string functions
---------------------

- len / strlen
- split
- join
- tolower
- toupper

`:normal! G` will move to the last line in the file, no matter to what G is mapped.

Execute Normal!
---------------

    execute "normal! gg/foo\<cr>dd"

    execute "normal! mqA;\<esc>`q"

Lists
-----

    echo ['foo', 3, 'bar']

- Indexing

Vimscript lists are zero-indexed, and you can get at the elements in the usual
way.

    echo [0, [1, 2]][1]

You can also index from the end of the list:

    echo [0, [1, 2]][-2]

Vim displays 0. The index -1 refers to the last element in the list, -2 is the
second-to-last, and so on.

- Slicing

Vim lists can also be sliced.

    echo ['a', 'b', 'c', 'd', 'e'][0:2]

    echo ['a', 'b', 'c', 'd', 'e'][0:100000]

Vim simply displays the entire list.

Slice indexes can be negative:

    echo ['a', 'b', 'c', 'd', 'e'][-2:-1]

Vim displays `['d', 'e']` (elements -2 and -1).

When slicing lists you can leave off the first index to mean "the beginning"
and/or the last index to mean "the end".

    echo ['a', 'b', 'c', 'd', 'e'][:1]
    echo ['a', 'b', 'c', 'd', 'e'][3:]

Vim displays `['a', 'b']` and `['d', 'e']`.

Vimscript allows you to index and slice strings too:

    echo "abcd"[0:2]

    echo "abcd"[-1] . "abcd"[-2:]

- Concatenation

		echo ['a', 'b'] + ['c']

- List Functions

		let foo = ['a']
		call add(foo, 'b')
		echo foo

		echo len(foo)

		echo get(foo, 0, 'default')
		echo get(foo, 100, 'default')


		echo index(foo, 'b')
		echo index(foo, 'nope')

		echo join(foo)
		echo join(foo, '---')
		echo join([1, 2, 3], '')

		call reverse(foo)

**Read :help List. All of it. Notice the capital L.**

For Loops
---------

- For

		let c = 0

		for i in [1, 2, 3, 4]
		  let c += i
		endfor

		echom c

Vim displays 10.

- While

		let c = 1
		let total = 0

		while c <= 4
		  let total += c
		  let c += 1
		endwhile

		echom total

Once again Vim displays 10.

Dictionaries
------------

    echo {'a': 1, 100: 'foo'}

- Indexing

		echo {'a': 1, 100: 'foo',}['a']
		echo {'a': 1, 100: 'foo',}[100]

		echo {'a': 1, 100: 'foo',}.a
		echo {'a': 1, 100: 'foo',}.100

- Assigning and Adding

		let foo = {'a': 1}
		let foo.a = 100
		let foo.b = 200
		echo foo

- Removing Entries

There are two ways to remove entries from a dictionary. Run the following
commands:

    let test = remove(foo, 'a')
    unlet foo.b
    echo foo
    echo test

Vim displays {} and 100. The remove function will remove the entry with the
given key from the given dictionary and return the removed value. The unlet
command also removes dictionary entries, but you can't use the value.

- Dictionary Functions

		echom get({'a': 100}, 'a', 'default')
		echom get({'a': 100}, 'b', 'default')

		echom has_key({'a': 100}, 'a')
		echom has_key({'a': 100}, 'b')

		echo items({'a': 100, 'b': 200})

		help keys
		help values

Paths
-----

	echom expand('%') - relative path of the current file
	echom expand('%:p') - absolute path of the current file
	echom fnamemodify('foo.txt', ':p')

	echo globpath('.', '*')

	echo split(globpath('.', '*'), '\n')

	echo split(globpath('.', '*.txt'), '\n')

	echo split(globpath('.', '**'), '\n')
