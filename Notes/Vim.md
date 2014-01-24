### [Byte of Vim](http://swaroopch.com/notes/vim/)

### Basic keys

| Key               | Action                                                        |
|-------------------|---------------------------------------------------------------|
| :e [name-of-file] | **edit** a file                                               |
| :w                | **write** the file                                            |
| I                 | **insert** text in the beginning of the line                  |
| i                 | **insert** text before the cursor                             |
| A                 | insert text at the end of the line (**after** the line)       |
| a                 | insert text **after** the cursor                              |
| o                 | insert line below the current one                             |
| O                 | insert line above the current one                             |
| s                 | **substitute** a symbol (after that stays in **insert** mode) |
| S                 | **substitute** the whole line                                 |
| r                 | **replace** a symbol (after that goes to **normal** mode)     |
| R                 | replace continuous characters                                 |
| v                 | go to **visual** mode for symbols                             |
| V                 | go to **visual** mode for lines                               |

### Movements

| Key    | Movement                                        |
|--------|---------------------------------------------    |
| h      | left                                            |
| j      | down                                            |
| k      | up                                              |
| l      | right                                           |
| ****** | ******                                          |
| 3fh    | move to the 3rd occurrence of the letter 'h     |
| ****** | ******                                          |
| ctrl+o | jump back to the previous location              |
| ctrl+i | jump forward to the next location again         |
| ****** | ******                                          |
| ^      | move to the start of the line (Home)            |
| $      | move to the end of the line (End)               |
| ctrl+b |  move one screen **backward** (PageUp)          |
| ctrl+f | move one screen **forward** (PageDown)          |
| ****** | ******                                          |
| 50G    | go to line 50                                   |
| 1G     | go to the beggining of the file                 |
| G      | go to the last line                             |
| ****** | ******                                          |
| H      | go to the first line of the screen ( **High** ) |
| L      | go to the last line of the screen ( **Low** )   |
| M      | go to the **middle** of the window              |
| ****** | ******                                          |
| w      | go to the next **word**                         |
| e      | go to the **end** of the word                   |
| b      | go **backword**                                 |
| ****** | ******                                          |
| )      | move to the next sentence                       |
| (      | move to the previous sentence                   |
| ****** | ******                                          |
| }      | move to the next paragraph                      |
| {      | move to the previous paragraph                  |

| Key | Action |
|-----|--------|
| ~   | change the case for the selected text |
|     |                                       |
| ma  | create a **mark** named **a** (save the current curson possition) (names can be a-zA-Z) |
| 'a  | jump back to the mark **a** |

### Visual mode:

- ap - select a paragraph
- aw - select a word
- a" - select a quoted string
- ab - select a block (within a pair of parentheses)


### Help:

- ctrl+] - follow a link in help
- ctrl+o - go back

:helpgrep [phrase]

### Ctrl+s for saving:

    " To save, ctrl-s.
    nmap <c-s> :w<CR>
    imap <c-s> <Esc>:w<CR>a

### Cut, Copy, Paste:

- cut -> delete -> d
- copy -> yank -> y
- paste -> paster -> p

- dl - delete one symbol
- dw - delete one word
- dd - delete one line
- yap - copy the current paragraph

- p - paste after current cursor position
- P - paste before current cursor position

- swap two characters - xp
- swap two words - dwwP

### Undo/Redo:

- u - undo
- ctrl+r - redo

    :earlier 4m
    :later 5s
    :undo 5
    :undolist

### Search:

    /word

    set incsearch
    set ignorecase
    set smartcase

- /\<step\> - search exactly for the word
- /\d - search for digit
- /\d\+ - search for one or more
- /\d\* - search for zero or more

### Fold:

- zo - **open** the fold
- zc - **close** the fold

### Buffers:

- :b 1 - go to buffer 1
- :buffers / :ls - list of buffers (open files)

### Windows:

- :new - open a new window
- ctrl+w + motions / ctrl+w x 2 - change current window
- :sp / ctrl+w+s - splits the current window
- :vsp / ctrl+w+v - vertical split
- ctrl+w+r - rotate windows
- ctrl+w+K - move the current window to the topmost position
- :resize 10 - resize a window to be 10 lines long
- ctrl+w - make the current window as big as possible

### Tabs:

- :tabnew - open a new tab
- gt - go to the next tab
- gT - go to the previous tab
- :tabmove [position] - move the tab to the given position

### vimrc files:

http://amix.dk/vim/vimrc.html
http://dotfiles.org/.vimrc