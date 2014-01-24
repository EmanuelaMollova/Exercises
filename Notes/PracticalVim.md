### Content

- [Compound Command - Equivalent in Longhand](#)
- [Intent - Act - Repeat - Reverse](#)
- [Operator + Motion = Action](#)
- [Text Objects](#)
- [Registers](#)
- [Substitude](#)
- [Global command](#)
- [C-tags](#)
- [Autocompletion](#)

******

- **dw** - in sequence, press d, then w
- **g<C-]>** - press g, followed by <Ctrl> and ] at the same time

- **$** Enter the command line in an external shell
- **:** Use Command-Line mode to execute an Ex command
- **/** Use Command-Line mode to perform a forward search
- **?** Use Command-Line mode to perform a backward search
- **=** Use Command-Line mode to evaluate a Vim script expression

### Compound Command - Equivalent in Longhand

- **C** - c$
- **s** - cl
- **S** - ^C
- **I** - ^i
- **A** - $a
- **o** - A<CR>
- **O** - ko

They all switch from Normal to Insert mode.

The **f{char}** command tells Vim to look ahead for the next occurrence of the
specified character and then move the cursor directly to it if a match is found.

The **;** command will repeat the last search that the f command performed.

### Intent - Act - Repeat - Reverse

| Intent                           | Act                   | Repeat | Reverse |
|----------------------------------|-----------------------|--------|---------|
| Make a change                    | {edit}                | .      | u       |
| Scan line for next character     | f{char}/t{char}       | ;      | ,       |
| Scan line for previous character | F{char}/T{char}       | ;      | ,       |
| Scan document for next match     | /pattern<CR>          | n      | N       |
| Scan document for previous match | ?pattern<CR>          | n      | N       |
| Perform substitution             | :s/target/replacement | &      | u       |
| Execute a sequence of changes    | qx{changes}q          | @x     | u       |

**The Dot Formula**: One Keystroke to Move, One Keystroke to Execute

**Example**: to append `;` at the end of each line:
- `A;<Esc>` and then move and apply with `j`.

The `u` key triggers the undo command, which reverts the most recent change.
A change could be anything that modifies the text in the document. In Vim, we
can control the granularity of the undo command. From the moment we enter Insert
mode until we return to Normal mode, everything we type (or delete) counts as a
single change. So we can make the undo command operate on words, sentences, or
paragraphs just by moderating our use of the `<Esc>` key.

Pressing **db** deletes from the cursor’s starting position to the beginning
of the word, but it leaves the first letter.

**daw** - delete a word

`<Ctrl-a>`, `[number]<Ctrl-x>` - add/substract the [number] from the first
number which is met

Operator + Motion = Action
--------------------------

The **d{motion}** command can operate on a single character (`dl`), a complete
word (`daw`), or an entire paragraph (`dap`). Its reach is defined by the motion.
The same goes for `c{motion}`, `y{motion}`, and a handful of others. Collectively,
these commands are called operators. You can find the complete list by
looking up :h operator.


Operators:
----------

- **c**  - Change
- **d**  - Delete
- **y**  - Yank into register
- **g~** - Swap case
- **gu** - Make lowercase
- **gU** - Make uppercase
- **>**  - Shift right
- **<**  - Shift left
- **=**  - Autoindent
- **!**  - Filter {motion} lines through an external program

### In insert mode:

- **<C-h>** - Delete back one character (backspace)
- **<C-w>** - Delete back one word
- **<C-u>** - Delete back to start of line

- **<C-[>** - switch back to normal mode

- **zt** - position the current line at the top
- **zz** - position the current line at the middle
- **zb** - position the current line at the bottom

- **<C-r>** - paste in insert mode

### Expression register: in insert mode - <C-r>=6*35<CR>

- **R** - enter in replace mode
- **gR** - another replace mode

- **v** - enter visual mode
- `<C-g>` - switch between visual and select modes (select mode is like
  selections in other languages.)

- `<C-n>` - to see suggestions for autocomplition

### Command - Effect

- **v** - Enable character-wise Visual mode
- **V** - Enable line-wise Visual mode
- **<C-v>** - Enable block-wise Visual mode
- **gv** - Reselect the last visual selection
- **o** - Go to other end of highlighted text

- **:1** - go to line 1
- **:$** - got to the last line
- **:%** - all lines in the file
- **2, 5** - lines from 2 to 5
- **:/<html>/+1,/<\/html>/-1p** - from the line after <html> to the line
  before </html>

### Symbol - Address

- **1** - First line of the file
- **$** - Last line of the file
- **0** - Virtual line above first line of the file
- **.** - Line where the cursor is placed
- **'m** - Line containing mark m
- **'<** - Start of visual selection
- **'>** - End of visual selection
- **%** - The entire file (shorthand for `:1,$`)
- **:[range]copy {address}** - `:6copy.` - copy line line on the current line
  (or Make a copy of line 6 and put it below the current line)

### Command - Effect

- **:6t.** - Copy line 6 to just below the current line
- **:t6** - Copy the current line to just below line 6
- **:t.** - Duplicate the current line (similar to Normal mode yyp)
- **:t$** - Copy the current line to the end of the file
- **:'<,'>t0** - Copy the visually selected lines to the start of the file

Note that `yyp` uses a register, while `:t`. doesn't.

- **:%normal i//** - comment the entire file

- **@:** - repeat the last Ex command
- `<C-o>` - do the reverse of the last Ex command

- `<C-r><C-w>` - insert the current word to the command line


- `<C-n>` - next
- `<C-p>` - previous

- **q:** - command-line window

- **q/** - Open the command-line window with history of searches
- **q:** - Open the command-line window with history of Ex commands
- **ctrl-f** - Switch from Command-Line mode to the command-line window

- **:! [cmd]** - execute one shell command

- **:shell, commands, $exit** - shell session

### Command - Effect

- **:shell** - Start a shell (return to Vim by typing exit)
- **:!{cmd}** - Execute {cmd} with the shell
- **:read !{cmd}** - Execute {cmd} in the shell and insert its standard output
  below the cursor
- **:[range]write !{cmd}** - Execute {cmd} in the shell with [range] lines as
  standard input
- **:[range]!{filter}** - Filter the specified [range] through external program
  {filter}

- `<C-^>` - switch between current (%) and alternate (#) buffers
  - :bprev, :bnext
  - :bfirst, :blast

- **:b [name-of-file] [number]** - open a buffer
- **:bufdo** - allows us to execute an Ex command in all of the buffers listed by :ls

- **:bd 1 2 3 4 5 10**, **:bd 5,10** - delete selected buffers

- **+** in front of the buffer means that is was modified, but not saved
- **a** is for active

If we don't write the changes to a buffer and try to open another and force the
opening, it will become hidden (h), on quitting Vim will ask what to do with
all hidden buffers. Here are the opportunities:

- **:w[rite]** - Write the contents of the buffer to disk
- **:e[dit]!** - Read the file from disk back into the buffer (that is, revert changes)
- **:qa[ll]!** - Close all windows, discarding changes without warning
- **:wa[ll]** - Write all modified buffers to disk

- **<C-w>s** - split horizontally
- **<C-w>v** - split vertically

- **:sp[lit] {file}** - Split the current window horizontally, loading {file} into
  the new window

### Ex Command - Normal Command - Effect

- **:cl[ose]** - **<C-w>c** - Close the active window

### Keystrokes Buffer Contents

- `<C-w>=` - Equalize width and height of all windows
- `<C-w>_` - Maximize height of the active window
- `<C-w>|` Maximize width of the active window
- `[N]<C-w>_` - Set active window height to [N] rows
- `[N]<C-w>|` - Set active window width to [N] columns

- `<C-w>T` - move the current window in a new tab

- **:tabe[dit] {filename}** - Open {filename} in a new tab
- `<C-w>T` - Move the current window into its own tab
- **:tabc[lose]** - Close the current tab page and all of its windows
- **:tabo[nly]** - Keep the active tab page, closing all others

- **:tabn[ext] {N}** - {N}gt - Switch to tab page number {N}
- **:tabn[ext]** - gt - Switch to the next tab page
- **:tabp[revious]** - gT - Switch to the previous tab page

We can use the `:tabmove [N]` Ex command to rearrange tab pages. When [N] is 0, the
current tab page is moved to the beginning, and if we omit [N], the current tab.

- **:edit.** - `(:e.)` - Open file explorer for current working directory page
  is moved to the end.

### Command Move Cursor

- **j** - Down one real line
- **gj** - Down one display line
- **k** - Up one real line
- **gk** - Up one display line
- **0** - To first character of real line
- **g0** - To first character of display line
- **^** - To first nonblank character of real line
- **g^** - To first nonblank character of display line
- **$** - To end of real line
- **g$** - To end of display line

- **w** - Forward to start of next word
- **b** - Backward to start of current/previous word
- **e** - Forward to end of current/next word
- **ge** - Backward to end of previous word

These are for words - we have 10 words here "e.g. we're going too slow"
For WORDS they are the same, but capitalized. - we have 5 WORDS.

- **f{char}** - Forward to the next occurrence of {char}
- **F{char}** - Backward to the previous occurrence of {char}
- **t{char}** - Forward to the character before the next occurrence of {char}
- **T{char}** - Backward to the character after the previous occurrence of {char}
- **;** - Repeat the last character-search command
- **,** - Reverse the last character-search command

- **/[some chars]** - search
- **n** - go to the next occurance
- **N** - go to the previous occurance

### Text Objects:

- **i** - selects the thing inside the delimiters
- **a** - selects the thing inside and the delimiters (around, all)

- **Text** - Object Selection
- **a)** (or **ab**) - A pair of (parentheses)
- **i)** (or **ib**) - Inside of (parentheses)
- **a}** (or **aB**) - A pair of {braces}
- **i}** (or **iB**) - Inside of {braces}
- **a]** - A pair of [brackets]
- **i]** - Inside of [brackets]
- **a>** - A pair of <angle brackets>
- **i>** - Inside of <angle brackets>
- **a’** - A pair of 'single quotes'
- **i’** - Inside of 'single quotes'
- **a"** - A pair of "double quotes"
- **i"** - Inside of "double quotes"
- a` - A pair of `backticks`
- i` - Inside of `backticks`
- **at** - A pair of <xml>tags</xml>
- **it** - Inside of <xml>tags</xml>

### Keystrokes Buffer Contents

- **iw** - Current word
- **aw** - Current word plus one space
- **iW** - Current WORD
- **aW** - Current WORD plus one space
- **is** - Current sentence
- **as** - Current sentence plus one space
- **ip** - Current paragraph
- **ap** - Current paragraph plus one blank line

Delete with **a**, change with **i** - `daw`, `ciw`

The **m{a-zA-Z}** command marks the current cursor location with the designated
letter **(:h m )**. Lowercase marks are local to each individual buffer, whereas
uppercase marks are globally accessible.

### Keystrokes - Buffer Contents

- **``** - Position before the last jump within current file
- **`.** - Location of last change
- **`^** - Location of last insertion
- **`[** - Start of last change or yank
- **`]** - End of last change or yank
- **`<** - Start of last visual selection
- **`>** - End of last visual selection

- `:jumps` - to open the jump list
- `<C-o>` - go backword
- `<C-i>` - go foward

- `:changes` - to open the change list
- **g;**
- **g,**

- **gf** - go to file (the word under the cursor)

- `:set suffixesadd+=.rb` - set which extensions to add to the word under the
  cursor

- `:set path` - set the path for Vim to search for the file (. stands for the
  directory of the current file, whereas the empty string (delimited by two
  adjacent commas) stands for the working directory)

- **xp** can be considered as "Transpose the next two characters."

- **ddp** can be considered as "Transpose the order of this line and its successor."

- **yyp** - duplicate a line

Registers:
----------

- `**""**` (unnamed) - x,s,d,c,y go to it
- `**"0**` (yank) - only y goes there
- **named registers**
- `__"*, "+__` - (system)
- `**"_**` (black hole)

### Register - Contents

- **"=** - Expression Register
- **"%** - Name of the current file
- **"#** - Name of the alternate file
- **".** - Last inserted text
- **":** - Last Ex command
- **"/** - Last search pattern

`<C-r>[register]` in insert mode pastes the content of the selected register

If we have recorded a macro in register `a`, we can append more actions to it
with `qA`.

To paste the content of the macro to a file, we can write `:put a`

You can force search sensitivity with `\c` and `\C`.

With `\v` you can search for regural expressions. (no need to escape `[`, `{` and so
on)

With `\V` you can search for verbatim text (everything is taken literally - no
special meanings)

If you want to search only for a word, and not the words in which it is
contained - surround the word with `<>`.

For example `/the` will find the, there, they..., but `/\v<the>` will match only
the.

- **/** - search forward
- **?** - search backward

The **n** command jumps to the next match, and the **N** command jumps to the
previous match.

If we execute a search without providing a pattern, Vim will just reuse the
pattern from the previous search.

`<C-r><C-w>` - autocompletes the search field using the remainder of the
current preview match.

`n:%s///gn` - shows the number of matches for a pattern.

Substitude
----------

**:[range]s[ubstitute]/{pattern}/{string}/[flags]**

Flags for the substitude command
--------------------------------

- **g** - makes the substitute command act globally, causing it to change all
matches within a line rather than just changing the first one.

- **c** - gives us the opportunity to confirm or reject each change.

- **y** - Substitute this match
- **n** - Skip this match
- **q** - Quit substituting
- **l** - "last" - Substitute this match, then quit
- **a** - "all" - Substitute this and any remaining matches
- `<C-e>` - Scroll the screen up
- `<C-y>` - Scroll the screen down


**n** - suppresses the usual substitute behavior, causing the command to report
the number of occurrences that would be affected if we ran the substitute
command.

If we run the substitute command using a pattern that has no matches in
the current file, Vim will report an error saying "E486: Pattern not found."
We can silence these errors by including the **e** flag.

**&** - simply tells Vim to reuse the same flags from the previous substitute
command.

- **\r** - Insert a carriage return
- **\t** - Insert a tab character
- **\\** - Insert a single backslash
- **\1** - Insert the first submatch
- **\2** - Insert the second submatch (and so on, up to \9)
- **\0** - Insert the entire matched pattern
- **&** - Insert the entire matched pattern
- **~** - Use {string} from the previous invocation of :substitute
- **\={Vim script}** - Evaluate {Vim script} expression; use result as replacement
  {string}

Look at this command:

    :%s/Pragmatic Vim/Practical Vim/g

Compare it with this sequence of commands:

    :let @/='Pragmatic Vim'
    :let @a='Practical Vim'
    :%s//\=@a/g

`:let @/='Pragmatic Vim'` is a programmatic way of setting the search pattern.
It has the same effect as executing the search `/Pragmatic Vim<CR>` (except
that running `:let @/='Pragmatic Vim'` does not create a record in the search
history).  Likewise, `:let @a='Practical Vim'` sets the contents of the a
register. The end result is the same as if we had visually selected the text
"Practical Vim" and then typed `"ay` to yank the selection into register a.

- **g&** - repeat a Line-Wise Substitution Across the Entire File

We can always specify a new range and replay the substitution using the **:&&**
command. It doesn’t matter what range was used the last time. **:&&** by itself
acts on the current line, **:'<,'>&&** acts on the visual selection, and
**:%&&** acts on the entire file. As we saw already, the g& command is a handy
shortcut for **:%&&.**

`Select only the digits in <h1>, </h2>, ... and substract 1 from them::w`

    /\v\<\/?h\zs\d

This substitute command should work:

    :%s//\=submatch(0)-1/g

    /\v(<man>|<dog>)
    :%s//\={"dog":"man","man":"dog"}[submatch(1)]/g

Global command:
---------------

**:[range] global[!] /{pattern}/ [cmd]**

The default range for the **:global** command is the entire file **(%).** That
sets it apart from most other Ex commands, including `:delete`, `:substitute`, and
`:normal`, whose range is the current line (`.`) by default. The **{pattern}** field
integrates with search history. That means we can leave it blank and Vim will
automatically use the current search pattern.  The **[cmd]** could be any Ex
command except for another :global command.

We can invert the behavior of the `:global` command either by running **:global!**
or **:vglobal** (mnemonic: invert). Each of these tells Vim to execute **[cmd]**
on each line that doesn’t match the specified pattern.

    :g/TODO/yank A
    :reg a
    "a // TODO: Cache this regexp for certain depths.
    // TODO: No matching end code found - warn!

The trick here is that we’ve addressed our register with an uppercase `A`. That
tells Vim to append to the specified register, whereas a lowercase `a` would
overwrite the register’s contents. We can read the global command as “For
each line that matches the pattern /TODO/, append the entire line into register
a.”

    :g/{start}/ .,{finish} [cmd]

We can read this as “For each range of lines beginning with {start} and ending
with {finish}, run the specified [cmd].”

We could use the same formula for a :global command in combination with
any Ex command. For example, suppose that we wanted to indent the specified
ranges. We could do so with the :> Ex command (see :h :> ):

    :g/{/ .+1,/}/-1 >
    6 lines >ed 1 time
    3 lines >ed 1 time

C-tags
======

Pressing `<C-]>` makes our cursor jump from the keyword under the cursor to
the definition. Here it is in action.

The `<C-t>` command acts as the back button for our tag history.

Instead of `<C-]>`, we could use the `g<C-]>` command. Both of these commands
behave identically in the case when the current keyword has only a single
match. But if it has multiple matches, then the `g<C-]>` command presents us
with a list of choices from the tag match list.

We could use the **:tselect** command to retrospectively pull up the menu of the
tag match list. Or we could use the **:tnext** command to jump to the next
matching tag without showing a prompt. As you might expect, this command
is complemented with **:tprev**, **:tfirst**, and **:tlast**.

- **:tag {keyword}** and **:tjump {keyword}** behave like the **<C-]>** and **g<C-]>**
  commands.

- **Command - Effect**

- `<C-]>` - Jump to the first tag that matches the word under the cursor.
- `g<C-]>` - Prompt user to select from multiple matches for the word under the
  cursor. If only one match exists, jump to it without prompting.
- **:tag {keyword}** - Jump to the first tag that matches {keyword}
- **:tjump {keyword}** - Prompt user to select from multiple matches for {keyword}.
  If only one match exists, jump to it without prompting.
- **:pop or <C-t>** - Reverse through tag history
- **:tag** - Advance through tag history
- **:tnext** - Jump to next matching tag
- **:tprev** - Jump to previous matching tag
- **:tfirst** - Jump to first matching tag
- **:tlast** - Jump to last matching tag
- **:tselect** - Prompt user to choose an item from the tag match list

Autocompletion
--------------

### Command - Type of Completion

- `<C-n>` Generic keywords
- `<C-x><C-n>` Current buffer keywords
- `<C-x><C-i>` Included file keywords
- `<C-x><C-]>` tags file keywords
- `<C-x><C-k>` Dictionary lookup
- `<C-x><C-l>` Whole line completion
- `<C-x><C-f>` Filename completion
- `<C-x><C-o>` Omni-completion

- **Keystrokes - Effect**
- `<C-n>` Use the next match from the word list (next match)
- `<C-p>` Use the previous match from the word list (previous match)
- `<Down>` Select the next match from the word list
- `<Up>` Select the previous match from the word list
- `<C-y>` Accept the currently selected match (yes)
- `<C-e>` Revert to the originally typed text (exit from autocompletion)
- `<C-h>` (and `<BS>`) Delete one character from current match
- `<C-l>` Add one character from current match
- `{char}` Stop completion and insert {char}

### Refine the Word List as You Type - `<C-n><C-p>`

The simplest mechanism for populating the autocomplete word list would be
to use words only from the **current buffer**. Current file keyword completion
does just that and is triggered with `<C-x><C-n>` (see `:h compl-current` ). This can
be useful when generic keyword completion generates too many suggestions
and you know that the word you want is somewhere in the current buffer.

To take keywords from included files, too - use `<C-x><C-i>`. Try opening a
Ruby or Python file and running :set include?, and you should find that Vim
already knows how to look up included files for those languages.

For tags file - `<C-x><C-]>`.

Autocomplete Words from the Dictionary - `<C-x><C-k>`.

Autocomplete entire line - `<C-x><C-l>`.

Autocomplete files - `<C-x><C-f>`.

Spellchecker
------------

`:set spell`

We can jump backward and forward between flagged words with the **[s** and
**]s** commands, respectively. With our cursor positioned on a misspelled
word, we can ask Vim for a list of suggested corrections by invoking
the **z=** command.

- **Command - Effect**
- **]s**    - Jump to next spelling error
- **[s**    - Jump to previous spelling error
- **z=**    - Suggest corrections for current word
- **zg**    - Add current word to spell file
- **zw**    - Remove current word from spell file
- **zug**   - Revert zg or zw command for current word

Auto correct with `<C-x><C-s>`.
