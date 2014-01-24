[Git CheatSheet](http://www.ndpsoftware.com/git-cheatsheet.html)

Sources:
========

1. [Try Git](http://try.github.io)
2. [Git - The Simple Guide](http://rogerdudler.github.io/git-guide/)
3. [A Visual Git Reference](http://marklodato.github.io/visual-git-guide/index-en.html)
4. [Official Git Tutorial](http://git-scm.com/docs/gittutorial)
5. [Everyday Git With 20 Commands Or So Manual Page](http://git-scm.com/docs/everyday)
6. [Git Reference](http://gitref.org/)    :heart:
7. [Git Immersion](http://gitimmersion.com/)
8. [Git from the bottom up](http://ftp.newartisans.com/pub/git.from.bottom.up.pdf)
9. [Git For Ages 4 And Up](http://blip.tv/open-source-developers-conference/git-for-ages-4-and-up-4460524)    :heart: 
10. [Git Magic](http://www-cs-students.stanford.edu/~blynn/gitmagic/index.html)
11. [Git is Simpler Than You Think](http://nfarina.com/post/9868516270/git-is-simpler)
12. Git Real
13. [The Thing About Git](http://tomayko.com/writings/the-thing-about-git)
14. Git Real 2
15. [Atlassian Git tutorial](https://www.atlassian.com/git/tutorial)
16. [The illustrated guide to recovering lost commits with Git](http://www.programblings.com/2008/06/07/the-illustrated-guide-to-recovering-lost-commits-with-git/)
17. [Think Like (a) Git](http://think-like-a-git.net/)    :heart: 
18. [Git Internals](https://peepcode.com/products/git-internals-pdf)    :heart:   (pages 10-49)
19. [Git for Computer Scientists](http://eagain.net/articles/git-for-computer-scientists/)
20. [Pro Git](http://git-scm.com/book)    :heart:


Content
=======

1. [**Understanding Git**](#understanding-git)
  - [Blobs](#contents-of-files---blobs)
  - [Trees](#directories---trees)
  - [Commit](#commit)
  - [Tag](#tag)
  - [The Git Data Model](#the-git-data-model)
  - [Example](#example)
  - [Branches](#branches)
  - [.git/objects/](#gitobjects)
  - [.git/refs/](#gitrefs)
  - [.git/HEAD/](#githead)
2. [**Configuration**](#configuration)   
3. [**Workflow**](#workflow)
4. [**HEAD**](#head)
5. [**References make commits reaachable**](#references-make-commits-reachable)
6. [**git commit**](#git-commit)    
  - [Ammend a Commit](#amend-a-commit)    
  - [Committing with a Detached HEAD](#detached-head)    
  - [Commit Messages](#commit-messages)    
7. [**git log**](#git-log)
8. [**git diff**](#git-diff)
9. [**Undoing**](#undoing)
  - [Simple Way of Saving State](#simple-way-of-saving-state)
  - [Undo/Redo](#undo-redo)
  - [Undoing Local Changes (before staging)](#undoing-local-changes-before-staging)
  - [Undoinig Staged Changes (before commiting)](#undoing-staged-changes-before-commiting)
  - [Undoing Commeted Changes](#undoing-commited-changes)
  - [Removing Commits from a Branch](removing-commits-from-a-branch)
10. [**git checkout**](#git-checkout)
  - [Checking out a commit](#checking-out-a-commit)
  - [Checking out a branch](#checking-out-a-branch)
  - [Checking out files](#checking-out-files)
  - [Detached HEAD](#detached-head)    
11. [**git reset**](#git-reset)
  - [Reset by Type](#reset-by-type)
  - [Options](#options)
12. [**git revert**](#git-revert)
13. [**git stash**](#stash)
14. [**git reflog**](#reflog)
15. [**Remove Files**](#remove-files)
  - [Rename Files](#rename-files)
16. [**git clean**](#git-clean)
17. [**Branches**](#branches-1)
  - [Remote Branches](#remote-branches)
  - [Branches as savepoints](#branches-as-savepoints)
18.	[**Merge**](#merge)
19. [**Cherry-pick**](#cherry-pick)
20. [**Rebase**](#rebase)
21. [**Bisect**](#bisect) 
22. [**Tags**](#tags)
23. [**Push Local Repo to Github**](#push-local-repo-to-github)
24.	[**Remote**](#git-remote)
25.	[**git clone**](#git-clone)	
26. [**git fetch**](#git-fetch)
27. [**git pull**](#git-pull)
28. [**Man Pages & Help**](#man-pages--help)
29. [**Aliases**](#aliases)
30. [**Internals**](#internals)


****************


Understanding Git
-----------------
[top](#content)

Git tracks content - files and directories. When Git stores a new version of a 
project, it stores a new tree - a bunch of blobs of content and a collection of 
pointers that can be expanded back out into a full directory of files and 
subdirectories. If you want a diff between two versions, it doesn’t add up all 
the deltas, it simply looks at the two trees and runs a new diff on them.

Git objects are the actual data of Git, the main thing that the repository is 
made up of. There are four main object types in Git. All of these types of 
objects are stored in the Git Object Database, which is kept in the Git 
Directory. Each object is compressed and referenced by the SHA-1 value of its 
contents plus a small header.

### contents of files -> blobs

It is important to note that it is the contents that are stored, not the files. 
The names and modes of the files are not stored with the blob, just the contents.
This means that if you have two files anywhere in your project that are exactly 
the same, even if they have different names, Git will only store the blob once. 
This also means that during repository transfers, such as clones or fetches, Git 
will only transfer the blob once, then expand it out into multiple files upon
checkout.

### directories -> trees

A tree is a simple list of trees and blobs that the tree contains, along with 
the names and modes of those trees and blobs. The contents section of a tree 
object consists of a very simple text file that lists the mode, type, name and 
sha of each entry.

    Tree:

    100644 blob a906cb README
    100644 blob a874b7 Rakefile
    040000 tree fe8971 lib

### Commit

The commit is very simple, much like the tree. It simply **points to a tree** 
and keeps an author, committer, message and any parent commits that directly 
preceded it.

### Tag

This is an object that provides a permanent shorthand name for a particular 
commit. It contains an object, type, tag, tagger and a message. Normally the 
type is commit and the object is the SHA-1 of the commit you’re tagging.

### The Git Data Model

Git object data is a directed acyclic graph. That is, starting at any commit you 
can traverse its parents in one direction and there is no chain that begins and 
ends with the same object. All commit objects point to a tree and optionally to 
previous commits. All trees point to one or many blobs and/or trees. Given this 
simple model, we can store and retrieve vast histories of complex trees of 
arbitrarily changing content quickly and efficiently.

In addition to the Git objects, which are immutable - that is, they cannot ever 
be changed, there are references also stored in Git. Unlike the objects, 
references can constantly change. They are simple pointers to a particular 
commit, something like a tag, but easily moveable. Examples of references are 
branches and remotes. A branch in Git is nothing more than a file in the 
.git/refs/heads/ directory that contains the SHA-1 of the most recent commit of
that branch. To branch that line of development, all Git does is create a new 
file in that directory that points to the same SHA-1. As you continue to commit, 
one of the branches will keep changing to point to the new commit SHA-1s, while
the other one can stay where it was.

### Example

    .
      `-- init.rb
      |-- lib
        `-- my_plugin.rb
        |-- base
          `-- base_include.rb
    

After commiting will look like this:

            Head
              |
           Branch
              |
           Commit
              |
            Tree 
             (.)
            /   \
         Tree   Blob
         (lib)  (init.rb)
        /    \
      Tree    Blob
      (base)  (my_plugin.rb)
       |
      Blob
      (base_include.rb)

### Branches

In fact, in Git the act of creating a new branch is simply writing a file in the 
.git/refs/heads directory that has the SHA-1 of the last commit for that branch.
Creating a branch is nothing more than just writing 40 characters to a file.
Switching to that branch simply means having Git make your working directory 
look like the tree that SHA-1 points to and updating the HEAD file so each commit 
from that point on moves that branch pointer forward (in other words, it changes 
the 40 characters in .git/refs/heads/[current_branch_name] be the SHA-1 of your 
last commit).

### .git/objects/

This is the main directory that holds the data of your Git objects - that is, 
all the contents of the files you have ever checked in, plus your commit, tree 
and tag objects. The files are stored by their SHA-1 values. The first two 
characters make up the subdirectory and the last 38 is the filename. For 
example, if the SHA-1 for a blob we’ve checked in was
a576fac355dd17e39fd2671b010e36299f713b4d
the file we would find the Zlib compressed contents in is:
[GIT_DIR]/objects/a5/76fac355dd17e39fd2671b010e36299f713b4d

### .git/refs/

This directory normally has three subdirectories in it - heads, remotes and tags. 
Each of these directories will hold files that correspond to your local branches, 
remote branches and tags, respectively. For example, if you create a development 
branch, the file .git/refs/heads/development will be created and will contain the 
SHA-1 of the commit that is the latest commit of that branch.

### .git/HEAD

This file holds a reference to the branch you are currently on. This basically 
tells Git what to use as the parent of your next commit. The contents of it will 
generally look like this:
ref: refs/heads/master

Configuration 
-------------
[top](#content)

    $ git config --global user.name "Your Name Comes Here"
    $ git config --global user.email you@yourdomain.example.com
	

Workflow
--------
[top](#content)

1. First go to the directory where the project is ( **cd** ) and write **git init**  
 
2. **git status** 
	
	( **git status -s** ) - there are two columns in the short status output. 
	The first column is for the staging area, the second is for the working 
	directory. 
		 
3. **git add**  
  - **git add .** - recursively adds all files in the project by specifying the 
    current working directory  		
  - __git add *__ will not add the files recursively if there are subfolders 
    with files in them  
		
4. [**git commit**](#commit) 
 
5. [**git log**](#git-log) - to see your commits  

*********

- **Staging Area**: A place where you can group files together before commit 
	them to Git.

- **Commit**: A commit is a snapshot of your repository. This way if you ever 
	need to look back at the changes you've made (or if someone else does), you 
	will see a nice timeline of all changes.

- **Staged**: Files are ready to be committed.

- **Unstaged**: Files with changes that have not been prepared to be commited.

- **Untracked**: Files aren't tracked by Git yet. This usually indicates a 
    newly created file.

- **Deleted**: File has been deleted and is waiting to be removed from Git.

Remember that each file in your working directory can be in one of two states: 
tracked or untracked. Tracked files are files that were in the last snapshot; 
they can be unmodified, modified, or staged. Untracked files are everything else - 
any files in your working directory that were not in your last snapshot and are 
not in your staging area.

HEAD
----
[top](#content)

- **HEAD** is the part of git that tracks what your current working directory 
should match.

- The **HEAD** is a pointer that holds your position within all your different 
commits. By default **HEAD** points to your most recent commit, so it can be 
used as a quick way to reference that commit without having to look up the SHA.

- The currently checked out commit is always called **HEAD**. If you check out a 
specific commit — instead of a branch name — then HEAD refers to that commit 
only and not to any branch. This case is somewhat special, and is called 
**_using a detached HEAD_**.

- **HEAD** contains a reference to either a branch name or a commit object 
(that case is a detached HEAD).

- **HEAD~** - the parent of HEAD
- **HEAD~2** - the parent of the parent of HEAD


References Make Commits Reachable
---------------------------------
[top](#content)

**References are pointers to commits.**

References come in several flavors: local branch, remote branch, and tag.

On disk, a local branch reference consists entirely of a file in your project's 
.git/refs/heads directory. This file contains the 40-byte identifier of the 
commit that the reference points to... and that's it. The entire file is 40 
bytes.

**Starting from every branch and every tag**, Git walks back through the graph, 
building a list of every commit it can reach.

**REFERENCES MAKE COMMITS REACHABLE.**

The unreachable commits are garbage collected.

**REFERENCES...**

...whether they are local branches, remote branches, or tags ...

**...MAKE COMMITS...**

...which are nodes in a graph ...

**...REACHABLE.**

...so that you can get back to them, and Git won't delete them when it decides 
it's time for spring cleaning.


git commit
----------
[top](#content)

- **git commit [files]** creates a new commit containing the contents of the 
    latest commit, plus a snapshot of [files] taken from the working directory. 
	Additionally, [files] are copied to the stage.

- **git commit -a** is equivalent to running git add on all filenames 
    that existed in the latest commit, on all files that are tracked and 
	then running git commit. It will automatically notice any modified 
    (but not new) files, add them to the index, and commit, all in one step.
	**You still need to run git add to start tracking new files, though.**

- **git tag v2.5 1b2e1d63ff** - giving a name to a commit (tag)
	
	
### Amend a commit

If you have missed something in your commit, or the commit message is wrong, 
you can use

**git commit --amend**

If you have missed some files just run **git add [files]** and then 
**git commit --amend**. If a message is not provided, the old one will be set.


### [Committing with a Detached HEAD](#committing-with-a-detached-head-1)


### Commit messages

Short (50 chars or less) summary of changes

More detailed explanatory text, if necessary.  Wrap it to about 72
characters or so.  In some contexts, the first line is treated as the
subject of an email and the rest of the text as the body.  The blank
line separating the summary from the body is critical (unless you omit
the body entirely); some git tools can get confused if you run the
two together.

Further paragraphs come after blank lines.

 - Bullet points are okay, too

 - Typically a hyphen or asterisk is used for the bullet, preceded by a
   single space, with blank lines in between, but conventions vary
   here

   
git log
-------
[top](#content)

- **git log [branchname]**
- **git lot [file]** - display commits that include the specified file. This 
  is an easy way to see the history of a particular file. 

- **--pretty** 

	With —pretty, you can choose between oneline, short, medium, full, fuller, 
	email, raw and format:(string), where (string) is a format you specify 
	with variables (ex: —format:”%an added %h on %ar” will give you a bunch of l
	ines like “Scott Chacon added f1cc9df 4 days ago”).
  
- **-[number]** - will limit the results to the last [number] commits.
- **-n [number]**
- **--max-count=[number]**

- **--pretty=oneline** - (the whole SHA is shown) 
- **--oneline** (SHA is 7 symbols only)

- **--author=[name]** - look for only commits from a specific author
- **--committer=[pattern]**

- **--all**   
- **--graph**
- **--decorate** - show tags also
- **--no-merges** - remove merge commits
- **--all-match** - to put AND between options; otherwise, git puts OR

- **git log --since --before** / **git log --until --after** - filter commits 
  by date committed
	
		$ git log --oneline --before={3.weeks.ago} --after={2010-04-18}		
		--since='5 minutes ago'
		
- **git log --grep** - filter commits by commit message

		$ git log --grep=P4EDITOR --no-merges
		
-  **git log --format**

		--format="%h %an %s"
		
- `git log --pretty=format:'%h %ad | %s%d [%an]' --graph --date=short`

  - **--pretty="..."** defines the format of the output.
  - **%h** is the abbreviated hash of the commit
  - **%d** are any decorations on that commit (e.g. branch heads or tags)
  - **%ad** is the author date
  - **%s** is the comment
  - **%an** is the author name
  - **--graph** informs git to display the commit tree in an ASCII graph layout
  - **--date=short** keeps the date format nice and short
		
- **git log -S** - filter by introduced diff

	What if you are looking for when a function was introduced, or where 
	variables started to be used? You can tell Git to **look through the diff** 
	of each commit for a string. Note there is no '=' between the '-S' and what you are 
	searching for.
	
- **git log --stat** - include which files were altered and the relative 
	number of lines that were added or deleted from each of them
	
- **git log -p** - show patch introduced at each commit

	For any commit you can get the patch that commit introduced to the project. 
	You can either do this by running **git show [SHA]** with a specific commit 
	SHA, or you can run **git log -p**, which tells Git to put the patch after 
	each commit.
	
- **git log stable..master** will list commits made in the master branch but 
	not in the stable branch;

	For any commit you can get the patch that commit introduced to the project. 
	You can either do this by running **git show [SHA]** with a specific commit 
	SHA, or you can run **git log -p**, which tells Git to put the patch after 
	each commit.

- **git log stable..master** will list commits made in the master branch but 
	not in the stable branch;

- **git log master..stable** will show the list of commits made on the stable 
	branch but not the master branch. It's the same as **git log stable ^master**
	
	If we are interested in merging in the 'erlang' branch we want to see what 
	commits are going to effect our snapshot when we do that merge. The way we 
	tell Git that is by putting a ^ in front of the branch that we don't want 
	to see. For instance, if we want to see the commits that are in the 'erlang' 
	branch that are not in the 'master' branch, we can do erlang ^master, 
	or vice versa. Note that the Windows command-line treats ^ as a special 
	character, in which case you'll need to surround ^master in quotes.

- **$ git log origin/master..HEAD** - shows any commits in your current branch 
    that aren’t in the master branch on your origin remote. If you run a git 
    push and your current branch is tracking origin/master, the commits listed 
    by git log origin/master..HEAD are the commits that will be transferred to 
    the server. You can also leave off one side of the syntax to have Git assume 
    HEAD. For example, you can get the same results as in the previous example 
    by typing git log origin/master.. — Git substitutes HEAD if one side is missing.    

The three commands are equivalent:

    $ git log refA..refB
    $ git log ^refA refB
    $ git log refB --not refA

- **...** - specifies all the commits that are reachable by either of two 
    references but not by both of them.

    It's useful to add `--left-right`, which shows which side of the range each 
    commit is in. This helps make the data more useful:

        $ git log --left-right master...experiment
        < F
        < E
        > D
        > C
   
   
git diff
--------
[top](#content)

- **git diff da985 b325c** - between **two commits**

- **git diff --cached** - between **HEAD** master and **Stage (Index)**

	Shows you what contents have been staged. That is, this will show you the 
	changes that will currently go into the next commit snapshot. 

- **git diff HEAD** - between **HEAD** master (the last commit) and **Working Directory**

- **git diff** - between **Stage (Index)** and **Working Directory**

    Displays in unified diff format (a patch) what code or content 
	you've changed in your project since the last commit that are 
	not yet staged for the next commit snapshot.

- **git diff [branch]** - between **another branch** and **Working Directory** 

- **git diff [version]** (tag) - see what has changed since the last release

- **git diff -stat** - gives a summary of changes

- **git diff master...erlang** - see just the changes that happened in the
	"erlang" branch
	
	As a bit of an aside, you can also have Git manually calculate what the 
	merge-base (first common ancestor commit) of any two commits would be 
	with the git merge-base command:

		$ git merge-base master erlang
		8d585ea6faf99facd39b55d6f6a3b3f481ad0d3d

	You can do the equivalent of git diff master...erlang by running this:

		$ git diff --stat $(git merge-base master erlang) erlang

You can also provide a file path at the end of any of these options to limit 
the diff output to a specific file or subdirectory.

*********

- **name^** - the parent of name

- **name^^ <=> name^2 <=> name~~ <=> name~2** - the parent of the parent

- **name:path** - to reference a certain file within a commit’s content tree, 
  specify that file’s name after a colon. This is helpful with show, or to
  show the difference between two versions of a committed file:
	
	$ git diff HEAD^1:Makefile HEAD^2:Makefile
	
- **name^{tree}** - you can reference just the tree held by a commit, rather 
  than the commit itself.

- **name1..name2** - this and the following aliases indicate commit ranges, 
  which are supremely useful with commands like **log** for seeing what’s happened
  during a particular span of time. The syntax to the left refers to all the 
  commits reachable from name2 back to, but not including, name1. If either name1 
  or name2 is omitted, HEAD is used in its place.

- **name1...name2** - a triple-dot range is quite different from the two-dot 
  version above. For commands like log, it refers to all the commits referenced
  by name1 or name2, but not by both. The result is then a list of all the unique 
  commits in both branches. For commands like **diff**, the range expressed is 
  between name2 and the common ancestor of name1 and name2. This differs from the 
  log case in that changes introduced by name1 are not shown.

- **master..** - this usage is equivalent to **master..HEAD**.

- **..master** - this, too, is especially useful aer you’ve done a fetch and 
  you want to see what changes have occurred since your last rebase or merge.
  
  
Showing Objects
---------------
[top](#content)

### Showing commits

The **git show** command is really useful for presenting any of the objects in a 
very human readable format. Running this command on a file will simply output 
the contents of the file. Running it on a tree will just give you the filenames 
of the contents of that tree, but none of its subtrees. Where it’s most useful 
is using it to look at commits.

### Showing trees

Instead of the git show command, it’s generally more useful to use the lower 
level **git ls-tree** command to view trees, because it gives you the SHA-1s of 
all the blobs and trees that it points to.

	$ git ls-tree master^{tree}
	
You can also run this command recursively, so you can see all the subtrees as 
well. This is a great way to get the SHA-1 of any blob anywhere in the tree 
without having to walk it one node at a time.

	$ git ls-tree -r -t master^{tree}
	
### Showing blobs

Lastly, you may want to extract the contents of individual blobs. The 
**cat-file** command is an easy way to do that, and can also serve to let you 
know what type of object a SHA-1 is, if you don’t know. It is sort of a 
catch-all command that you can use to inspect objects.

	$ git cat-file -t ae850bd698b2b5dfbac
	tree
	$ git cat-file -p ae850bd698b2b5dfbac
	100644 blob 7e92ed361869246dc76 simplegit.rb
	$ git cat-file -t 569b350811
	blob
	$ git cat-file -p 569b350811
	SimpleGit Ruby Library
	
  
Interactive add
---------------

**git add -i**

- update - to stage files
- revert - to unstage files
- diff - like `git diff --cached` 


Undoing
-------
[top](#content)

### Simple way of Saving State

	$ git add .
	$ git commit -m "My first backup"
	
To restore to the first backup:
	
	$ git reset --hard
	
To save the state again:

	$ git commit -am "Another backup"
	
### Undo/Redo

**$ git reset --hard 766f** - to restore the state to a given commit and erase 
all newer commits from the record permanently

**$ git checkout 82f5** - this takes you back in time, while preserving newer 
commits. However, like time travel in a science-fiction movie, if you now edit 
and commit, you will be in an alternate reality, because your actions are 
different to what they were the first time around.

This alternate reality is called a branch.

**$ git checkout master** will take you back to the present. Also, to stop Git 
complaining, always commit or reset your changes before running checkout.

You can choose only to restore particular files and subdirectories by appending 
them after the command:

	$ git checkout 82f5 some.file another.file
	
Take care, as this form of checkout can silently overwrite files. To prevent 
accidents, commit before running any checkout command, especially when first 
learning Git. In general, whenever you feel unsure about any operation, Git 
command or not, first run git commit -a.

Don’t like cutting and pasting hashes? Then use:

	$ git checkout :/"My first b"

#### Exercise

Let A, B, C, D be four successive commits where B is the same as A except some 
files have been removed. We want to add the files back at D. How can we do this?

There are at least three solutions. Assuming we are at D:

1. The difference between A and B are the removed files. We can create a patch 
representing this difference and apply it:

	$ git diff B A | git apply
	
2. Since we saved the files back at A, we can retrieve them:

	$ git checkout A foo.c bar.h
	
3. We can view going from A to B as a change we want to undo:

	$ git revert B
	

### Undoing Local Changes (before staging)

1. Change hello.rb

		# This is a bad comment.  We want to revert it.
		name = ARGV.first || "World"
		puts "Hello, #{name}!"
	
2. Check the Status

	`git status` (modified)

3. Revert the changes in the working directory

	`git checkout hello.rb`  

	This will change hello.rb to the staged file hello.rb.

	`git status`  
	`cat hello.rb`  

		$ git checkout hello.rb
		$ git status
		# On branch master
		nothing to commit (working directory clean)
		$ cat hello.rb
		# Default is "World"
		name = ARGV.first || "World"
		puts "Hello, #{name}!"
		
### Undoinig Staged Changes (before commiting)

1. Change the file and stage the change

		# This is an unwanted but staged comment
		name = ARGV.first || "World"
		puts "Hello, #{name}!"
	
	`git add hello.rb`
	
2. Check the Status

	`git status` (modified)

3. Reset the Staging Area

	`git reset HEAD hello.rb`

	This will unstage the file, but will not change the working directory.

		$ git reset HEAD hello.rb
		Unstaged changes after reset:
		M	hello.rb
	
4. Checkout the Committed Version

	`git checkout hello.rb`    

	This will change hello.rb to the staged file hello.rb.

	`git status`
 
		$ git status
		# On branch master
		nothing to commit (working directory clean)
	
### Undoing Commited Changes

1. Change the file and commit it.

		# This is an unwanted but committed change
		name = ARGV.first || "World"
		puts "Hello, #{name}!"
		
	`git add hello.rb`    
	`git commit -m "Oops, we didn't want this commit"`

2. Create a Reverting Commit

	`git revert HEAD`

		$ git revert HEAD --no-edit
		[master a10293f] Revert "Oops, we didn't want this commit"
		 1 files changed, 1 insertions(+), 1 deletions(-)
	 
### Removing Commits from a Branch

1. Check Our History

	`git hist`

		$ git hist
		* a10293f 2013-04-13 | Revert "Oops, we didn't want this commit" (HEAD, master) [Jim Weirich]
		* 838742c 2013-04-13 | Oops, we didn't want this commit [Jim Weirich]
		* 1f7ec5e 2013-04-13 | Added a comment (v1) [Jim Weirich]
		* 582495a 2013-04-13 | Added a default value (v1-beta) [Jim Weirich]
		* 323e28d 2013-04-13 | Using ARGV [Jim Weirich]
		* 9416416 2013-04-13 | First Commit [Jim Weirich]
	
2. Mark this Branch

	`git tag oops`

3. Reset to Before Oops

	`git reset --hard v1`    
	`git hist`

		$ git reset --hard v1
		HEAD is now at 1f7ec5e Added a comment
		$ git hist
		* 1f7ec5e 2013-04-13 | Added a comment (HEAD, v1, master) [Jim Weirich]
		* 582495a 2013-04-13 | Added a default value (v1-beta) [Jim Weirich]
		* 323e28d 2013-04-13 | Using ARGV [Jim Weirich]
		* 9416416 2013-04-13 | First Commit [Jim Weirich]
	
4. The commits are still there

	`git hist --all`

		$ git hist --all
		* a10293f 2013-04-13 | Revert "Oops, we didn't want this commit" (oops) [Jim Weirich]
		* 838742c 2013-04-13 | Oops, we didn't want this commit [Jim Weirich]
		* 1f7ec5e 2013-04-13 | Added a comment (HEAD, v1, master) [Jim Weirich]
		* 582495a 2013-04-13 | Added a default value (v1-beta) [Jim Weirich]
		* 323e28d 2013-04-13 | Using ARGV [Jim Weirich]
		* 9416416 2013-04-13 | First Commit [Jim Weirich]
	
5. Removing tag oops

	`git tag -d oops`    
	`git hist --all`

		$ git tag -d oops
		Deleted tag 'oops' (was a10293f)
		$ git hist --all
		* 1f7ec5e 2013-04-13 | Added a comment (HEAD, v1, master) [Jim Weirich]
		* 582495a 2013-04-13 | Added a default value (v1-beta) [Jim Weirich]
		* 323e28d 2013-04-13 | Using ARGV [Jim Weirich]
		* 9416416 2013-04-13 | First Commit [Jim Weirich]

		
git checkout
------------
[top](#content)

The checkout command is used to copy files from the history (or stage) to the 
working directory, and to optionally switch branches.

It serves three distinct functions: checking out **files**, 
checking out **commits**, and checking out **branches**.

### Checking out a commit

Checking out a commit makes the entire working directory match that commit. 
This can be used to view an old state of your project without altering your 
current state in any way. 

Checking out an old commit is a read-only operation. It’s impossible to harm
your repository while viewing an old revision. The current state of your 
project remains untouched in the master branch. 

During the normal course of development, the **HEAD** usually points to master 
or some other local branch, but when you check out a previous commit, **HEAD** 
no longer points to a branch — it points directly to a commit. This is called a 
**detached HEAD** state.

- **git checkout [commit]** - update all files in the working directory to match 
the specified commit. You can use either a commit hash or a tag as the <commit> 
argument. This will put you in a detached HEAD state.

### Checking out a branch

By checking out a branch by name, you go to the latest version of that branch.

### Checking out files

Checking out a file lets you see an old version of that particular file, 
leaving the rest of your working directory untouched.

- **git checkout [commit] [file]** - check out a previous version of a file. 
This turns the <file> that resides in the working directory into an exact copy 
of the one from <commit> and adds it to the staging area. (If no commit name is 
given, files are copied from the stage.) Note that the current branch is not 
changed.The above **does affect the current state of your project, of your 
repository**. The old file revision will show up as a **Change to be committed**, 
giving you the opportunity to revert back to the previous version of the file 
(you can re-commit the old version in a new snapshot as you would any other 
file, so, this usage serves as a way to revert back to an old version of an 
individual file). 

If you decide you don’t want to keep the old version, you can check out the most 
recent version with the following: `git checkout HEAD hello.py`

**git checkout -- filename** replaces the changes in your working tree with the 
last content in HEAD. Changes already added to the index, as well as new files, 
will be kept. But this should happen before commit and before add. For example 
you commit file a.txt with content FILE A, then you make changes to that file 
and NOT stage them and if you run git checkout -- a.txt its content will be 
FILE A again.

The difference between **git checkout -- files** and **git checkout HEAD -- files** 
is that if you have a file with content **x** and you change it and don't run 
git add file and run the commands, both of them will change the content of the 
file to **x** (the content in the latest commit), but if you run **git add file** 
and then run the commands, **git checkout -- file** won't do anything, the 
content of the file will not change, while after **git checkout HEAD -- file** 
the content will be changed to **x**.

### Detached HEAD

When a filename is not given and the reference is not a (local) branch — 
say, it is a tag, a remote branch, a SHA-1 ID, or something like master~3 — 
we get an anonymous branch, called a **detached HEAD**. This is useful for 
jumping around the history. Say you want to compile version 1.6.6.1 of git. 
You can **git checkout v1.6.6.1** (which is a tag, not a branch), compile, 
install, and then switch back to another branch, say **git checkout master**. 
However, committing works slightly differently with a detached HEAD.

A **detached HEAD** message in git just means that HEAD (the part of git 
that tracks what your current working directory should match) is pointing 
directly to a commit rather than a branch. Any changes that are committed 
in this state are only remembered as long as you don’t switch to a different 
branch. As soon as you checkout a new branch or tag, the detached commits will 
be lost (because HEAD has moved). If you want to save commits done in a 
detached state, you need to create a branch to remember the commits.

Or, in other words, when HEAD is detached, commits work like normal, except no 
named branch gets updated. (You can think of this as an anonymous branch.)

Once you check out something else, say master, the commit is (presumably) no 
longer referenced by anything else, and gets lost. 

If, on the other hand, you want to save this state, you can create a new 
named branch using **git checkout -b [name]**.

*********

Say you’re working on some feature, and for some reason, you need to go back 
three versions and temporarily put in a few print statements to see how 
something works. Then:

	$ git commit -a
	$ git checkout HEAD~3
	
Now you can add ugly temporary code all over the place. You can even commit 
these changes. When you’re done, `$ git checkout master` to return to your 
original work. Observe that any uncommitted changes are carried over.

What if you wanted to save the temporary changes after all? Easy:
`$ git checkout -b dirty` and commit before switching back to the master 
branch. Whenever you want to return to the dirty changes, simply type:
`$ git checkout dirty`.

In other words, after checking out an old state, Git automatically puts you in 
a new, unnamed branch, which can be named and saved with **git checkout -b**.

*****************************

In their simplest form, [reset](#git-reset) resets the index without touching 
the working tree, while [checkout](#git-checkout) changes the working tree 
without touching the index.

	
git reset
---------
[top](#content)

Reset should only be used to undo local changes — you should never reset 
snapshots that have been shared with other developers.

You can unstage files by using the git reset command.

You can use **git reset**  to remove a file or files from the staging area. 
It's like undo of git add.

### Reset by type

Basically, reset is a reference editor, an index editor, and a working tree editor.

When given a commit reference (i.e. a hash, branch or tag name), the reset 
command will:

  - Rewrite the current branch to point to the specified commit
  - Optionally reset the staging area to match the specified commit
  - Optionally reset the working directory to match the specified commit

It also is used to copy files  from the history to the stage without touching 
the working directory.

*********

If a commit is not given, it defaults to HEAD. In this case, the branch is not moved, 
but the stage (and optionally the working directory, if **--hard** is given) are 
reset to the contents of the last commit:

- **git reset [file]** - remove the specified file from the staging area, but 
leave the working directory unchanged. This unstages a file without overwriting 
any changes. This works similarly to checkout with a filename, except only the 
stage (and not the working directory) is updated. 

- **git reset** - reset the staging area to match the most recent commit, but 
leave the working directory unchanged. This unstages all files without 
overwriting any changes, giving you the opportunity to re-build the staged 
snapshot from scratch.

- **git reset --hard** - reset the staging area and the working directory to 
match the most recent commit. In addition to unstaging changes, the --hard 
flag tells Git to overwrite all changes in the working directory, too. Put 
another way: this obliterates all uncommitted changes, so make sure you 
really want to throw away your local developments before using it.

*********

- **git reset [commit]** - the current branch is moved to that commit, and then 
the stage is updated to match this commit. If **--hard** is given, the working 
directory is also updated. If **--soft** is given, neither is updated.
All changes made since <commit> will reside in the working directory, which 
lets you re-commit the project history using cleaner, more atomic snapshots.

- **git reset --hard [commit]** - move the current branch tip backward to 
<commit> and reset both the staging area and the working directory to match. 
This obliterates not only the uncommitted changes, but all commits after 
<commit>, as well.

### Options

- **git reset (--mixed)** - --mixed option (or no option at all, as this is the 
default), reset will revert parts of your index along with your HEAD reference
to match the given commit. The main difference from --soft is that --soft only 
changes the meaning of HEAD and doesn’t touch the index.

-   **git reset HEAD** - undo the last commit and unstage the files

	First, you can use it to unstage something that has been accidentally staged. 
	Let's say that you have modified two files and want to record them into two 
	different commits. You should stage and commit one, then stage and commit 
	the other. If you accidentally stage both of them, how do you un-stage one? 
	You do it with git reset HEAD -- file. Technically you don't have to add 
	the -- - it is used to tell Git when you have stopped listing options 
	and are now listing file paths, but it's probably good to get into the 
	habit of using it to separate options from paths even if you don't need to.
	
- 	**git reset --soft** - undo the last commit

	The first thing git reset does is undo the last commit and put the files 
	back onto the stage. If you include the --soft flag this is where it stops. 
	For example, if you run git reset --soft HEAD~ (the parent of the HEAD) 
	the last commit will be undone and the files touched will be back on 
	the stage again.
	
	This is basically doing the same thing as git commit --amend, allowing 
	you to do more work before you roll in the file changes into the same commit.
	
	If you use the --soft option to reset, this is the same as simply changing 
	your HEAD reference to a different commit. Your working tree changes are 
	left untouched. Your working tree now sits on top of an older HEAD, so you 
	should see more changes if you run status. It’s not that your file have 
	been changed, simply that they are now being compared against an older 
	version. It can give you a chance to create a new commit in place of the 
	old one.
	
-   **git reset --hard** - undo the last commit, unstage files AND undo any 
    changes in the working directory
	
	The third option is to go --hard and make your working directory look like 
	the index, unstage files and undo the last commit. This is the most dangerous 
	option and not working directory safe. Any changes not in the index or have 
	not been commited will be lost.

	A hard reset (the --hard option) has the potential of being very dangerous, 
	as it’s able to do two different things at once: First, if you do a hard 
	reset against your current HEAD, it will erase all changes in your working 
	tree, so that your current files match the contents of HEAD. There is also 
	another command, checkout, which operates just like reset --hard if the index
	is empty. Otherwise, it forces your working tree to match the index.
	
	Now, if you do a hard reset against an earlier commit, it’s the same as first 
	doing a soft reset and then using reset --hard to reset your working tree. 
	Thus, the following commands are equivalent:
	
		$ git reset --hard HEAD~3 # Go back in time, throwing away changes
		
	and
		
		$ git reset --soft HEAD~3 # Set HEAD to point to an earlier commit
		$ git reset --hard # Wipe out differences in the working tree
		
	As you can see, doing a hard reset can be very destructive. Fortunately,
	there is a safer way to achieve the same effect, using the Git stash 
	(see the next section):
	
		$ git stash
		$ git checkout -b new-branch HEAD~3 # head back in time!
		
	To be on the safe side, never use reset --hard without first running stash. 
	It will save you many white hairs later on. If you did run stash, you can 
	now use it to recover your working tree changes as well:
	
		$ git stash # because it's always a good thing to do
		$ git reset --hard HEAD~3 # go back in time
		$ git reset --hard HEAD@{1} # oops, that was a mistake, undo it!
		$ git stash apply # and bring back my working tree changes

*********

- `$ git reset --hard 5f1bc85`

The `--hard` option says to erase all changes currently in my working tree, 
whether they’ve been registered for a checkin or not. A safer way to do the 
same thing is by using checkout:

- `$ git checkout 5f1bc85`

The difference here is that changed files in my working tree are preserved. 
If I pass the `-f` option to checkout, it acts the same in this case to 
**reset --hard**, except that **checkout** only ever changes the working tree, 
whereas **reset --hard** changes the current branch's HEAD to reference the 
specified version of the tree.
		
	
git revert
----------
[top](#content)

The git revert command undoes a committed snapshot. But, instead of removing 
the commit from the project history, it figures out how to undo the changes 
introduced by the commit and appends a new commit with the resulting content. 
This prevents Git from losing history, which is important for the integrity of 
your revision history and for reliable collaboration.

It's important to understand that git revert undoes a single commit — it does 
not "revert" back to the previous state of a project by removing all subsequent 
commits. In Git, this is actually called a reset, not a revert.

Reverting has two important advantages over resetting. 

- First, it doesn’t change the project history, which makes it a safe operation 
for commits that have already been published to a shared repository. 

- Second, git revert is able to target an individual commit at an arbitrary point 
in the history, whereas git reset can only work backwards from the current commit. 
For example, if you wanted to undo an old commit with git reset, you would have 
to remove all of the commits that occurred after the target commit, remove it, 
then re-commit all of the subsequent commits. Needless to say, this is not an 
elegant undo solution.


git stash
---------
[top](#content)

Stashing takes the current state of the working directory and index, puts it on 
a stack for later, and gives you back a clean working directory. It will then 
leave you at the state of the last commit.

-   **git stash** - add current changes to the stack

-	**git stash save [optional:stash-message]**
	
- 	**git stash save --keep-index** - will not stash the staging area

-   **git stash save --include-untracked**
	
-	**git stash list** - view stashes currently on the stack

-	**git stash branch [name-of-branch] [name-of-stash]** - if you delete the
	branch where your stash was, this will create a new branch and will pop the
	the stash there.
	
	It's helpful to know what you've got stowed on the stash and this is where 
	git stash list comes in. Running this command will display a queue of 
	current stash items. The last item added onto the stash will be referenced 
	by stash@{0} and increment those already there by one.

- 	**git stash show [name-of-stash]** - show information about a specific stash	
	
- **--stat** - see patch of changes


Git stash show and git stash list can take any option that the git log command
can take.

-	**git stash apply** - grab the item from the stash list and apply to 
	current working directory, but it doesn't delete the stash from the 
	stash stack
	
	When you're ready to continue from where you left off, run the git stash 
	apply command to bring back the saved changes onto the working directory.
	By default it will reapply the last added stash item to the working 
	directory. This will be the item referenced by stash@{0}. You can grab 
	another stash item instead if you reference it in the arguments list. 
	For example, git stash apply stash@{1} will apply the item referenced 
	by stash@{1}.

    The changes to your files are reapplied, but the file you staged before 
    wasn’t restaged. To do that, you must run the git stash apply command with a 
    `--index` option to tell the command to try to reapply the staged changes. 
    If you had run that instead, you’d have gotten back to your original
    position.

	If you also want to remove the item from the stack at the same time when
	you apply it, use **git stash pop** instead. If **git stash pop** went 
	into conflict, it will not delete the stash.
	
- 	**git stash drop** - remove an item from the stash list
	When you're done with the stashed item and/or want to remove it from the list, 
	run the git stash drop command. By default this will remove the last added 
	stash item. You can also remove a specific item if you include it as an argument.
	
	If you want to remove of all the stored items, just run the git stash clear 
	command. But only do this if you're sure you're done with the stash.
	
		$ git log stash@{32} # when did I do it?
		$ git show stash@{32} # show me what I was working on
		$ git checkout -b temp stash@{32} # let’s see that old working tree!
	
If you ever want to clean up your stash list—say to keep only the last 30 days 
of activity — don’t use stash clear; use the reflog expire command instead:

	$ git stash clear # DON'T! You'll lose all that history
	$ git reflog expire --expire=30.days refs/stash
	<outputs the stash bundles that've been kept>

- **unapply a stash** - `$ git stash show -p stash@{0} | git apply -R`

- **git stash branch [branch-name]** - creates a new branch, checks out the commit you 
    were on when you stashed your work, reapplies your work there, and then 
    drops the stash if it applies successfully.
	
	
git reflog
----------
[top](#content)

**git reflog** is a kind of meta-repository that records — in the form of 
commits — every change you make to your repository. This means that when you 
create a tree from your index and store it under a commit (all of which is done 
by commit), you are also inadvertently adding that commit to the reflog, which 
can be viewed using the following command:

	$ git reflog
	5f1bc85... HEAD@{0}: commit (initial): Initial commit
    
    git show master@{yesterday}
    git show master@{2.months.ago}
    
	
The beauty of the reflog is that it persists independently of other changes in 
your repository. This means I could unlink the above commit from my repository 
(using reset), yet it would still be referenced by the reflog for another 30 
days, protecting it from garbage collection. This gives me a month’s chance to 
recover the commit should I discover I really need it.

Each time the HEAD moves, a record is recorded in reflog.

git log --walk-reflogs (git log -g)

If we delete a branch - git reflog to find the last commit in it and then
git branch the SHA of that commit


Remove files
------------
[top](#content)

To remove a file from Git, you have to remove it from your tracked files (more 
accurately, remove it from your staging area) and then commit.

**git rm** will remove entries from the staging area. This is a bit different 
from [**git reset HEAD**](#reset) which **unstages** files. To **unstage** 
means it reverts the staging area to what was there before we started modifying
things. **git rm** on the other hand just kicks the file off the stage entirely, 
so that it's not ncluded in the next commit snapshot, thereby effectively 
deleting it.

- **git rm** - not only remove the actual files from disk, but will also stage 
    the removal of the files
	
-  **git rm --cached** - remove the file only from git and leave it in the
	working directory

- **git rm -r [folder]** - will recursively remove all folders and files 
    from the given directory

If you happen to delete a file without using **git rm** you'll find that you 
still have to **git rm** the deleted files from the working tree. You can save 
this step by using the `-a` option on **git commit**, which auto removes deleted 
files with the commit:

**git commit -am "Delete stuff"**

### Rename files

**git mv [old-name] [new-name]** 

It's the same as:

	git rm --cached orig
	mv orig new 
	git add new
	
	
git clean
---------
[top](#content)

The git clean command removes untracked files from your working directory.

The git clean command is often executed in conjunction with git reset --hard. 
Remember that resetting only affects tracked files, so a separate command is 
required for cleaning up untracked ones. Combined, these two commands let you 
return the working directory to the exact state of a particular commit.

- **git clean -n** - shows which files are going to be removed without actually 
  doing it
  
- **git clean -f** - removes untracked files from the current directory. The -f 
  (force) flag is required unless the clean.requireForce configuration option is 
  set to false (it's true by default). This will not remove untracked folders or 
  files specified by .gitignore.

- **git clean -f [path]** - removes untracked files, but limit the operation to the 
  specified path.

- **git clean -df** - removes untracked files and untracked directories from the 
  current directory.

- **git clean -xf** - removes untracked files from the current directory as well 
  as any files that Git usually ignores
  
Keep in mind that, along with git reset, git clean is one of the only Git 
commands that has the potential to permanently delete commits, so be careful 
with it. 


Branches
--------
[top](#content)

The name of any branch is simply an alias for the most recent commit on that 
branch. This is the same as using the word HEAD whenever that branch is 
checked out. You can think of them as a way to request a brand new working 
directory, staging area, and project history. 

It's important to understand that branches are just **pointers to commits**. 
When you create a branch, all Git needs to do is create a new pointer—it 
doesn’t change the repository in any other way. Branching safely isolates 
work that we do into contexts we can switch between.

If you start on work it is very useful to always start it in a branch (because
it's fast and easy to do) and then merge it in and delete the branch when 
you're done. That way if what you're working on doesn't work out you can easily 
discard it and if you're forced to switch back to a more stable context your 
work in progress is easy to put aside and then come back to.

-   **git branch [name-of-branch]** - create a new branch

	It creates the branch at your last commit so if you record some commits at 
	this point and then switch to the new branch, it will revert your working 
	directory context back to when you created the branch in the first place - 
	**you can think of it like a bookmark for where you currently are**.

-   **git checkout [name-of-branch]** - switch branches. It’s best to have a 
    clean working state when you switch branches.

-   **git checkout -b [name-of-branch]** - checkout and create a branch at the 
	same time (immediately switch to a new branch)
	
-	**git checkout -b [new-branch] [existing-branch] - same as the above 
	invocation, but base the new branch off of <existing-branch> instead of the 
	current branch.
	
-   **git branch -d [name-of-branch]** - delete a branch if it's merged
- 	**git branch -D [name-of-branch]** - delete the specified branch, even if 
	it has unmerged changes

-   **git branch** - list your available branches
-	**git branch -a** - show all branches (remote also)
-	**git branch -v** - see the last commit on each branch
-   **git branch -r** - list the remote branches
-   **git show-branch [name-of-branch]** - show a specific branch
-   **git branch --merged (--no-merged)**

- 	**git branch -m [new-name]** - rename the current branch

-	**git push [remote-name] :[branchname]** - delete a remote branch only from 
	Github (or other server)

    Remote branches are references to the state of branches on your remote 
    repositories. They’re local branches that you can’t move; they’re moved 
    automatically whenever you do any network communication. Remote branches 
    act as bookmarks to remind you where the branches on your remote repositories 
    were the last time you connected to them.

    Pushing remote branches:
    `git push [remote-name] [local-branch]:[remote-branch]`

    `git push origin serverfix:awesomebranch` will push your local serverfix branch 
    to the awesomebranch branch on the remote project.

	When you're done with a remote branch, whether it's been merged into the 
	remote master or you want to abandon it and sweep it under the rug, you'll 
	issue a git push command with a specially placed colon symbol to remove 
	that branch.

		$ git push origin :tidy-cutlery
		To git@github.com:octocat/Spoon-Knife.git
		 - [deleted]         tidy-cutlery
	 
	In the above example you've deleted the "tidy-cutlery" branch of the 
	"origin" remote. A way to remember this is to think of the 
	**git push remote-name local-branch:remote-branch** syntax. 
	This states that you want to push your local branch to match that of the remote. 
	When you remove the local-branch portion you're now matching nothing to the 
	remote, effectively telling the remote branch to become nothing.

	Alternatively, you can run **git push remote-name --delete branchname** 
	which is a wrapper for the colon refspec (a source:destination pair) of 
	deleting a remote branch. 
	
    ### Remote branches

	Remote branches are just like local branches, except they represent commits 
	from somebody else’s repository. You can check out a remote branch just like 
	a local one, but this puts you in a detached HEAD state (just like checking 
	out an old commit). You can think of them as read-only branches. To view your 
	remote branches, simply pass the -r flag to the git branch command. Remote 
	branches are prefixed by the remote they belong to so that you don’t mix them
	up with local branches. For example, the next code snippet shows the branches 
	you might see after fetching from the origin remote:

            git branch -r
            # origin/master
            # origin/develop
            # origin/some-feature
				
### Branches as savepoints

Because a Git branch is just a 40-byte file on disk, it takes orders of 
magnitude more time for you to tell the computer to create a branch (by typing 
git branch foo) than for your computer to actually do it.

And because branches are references, and (say it with me now) references make 
commits reachable, creating a branch is a way to "nail down" part of the graph 
that you might want to come back to later.

And because neither git merge nor git rebase will change your existing commits 
(remember, a commit's ID is a hash of its contents and its history), you can 
create a temporary branch any time you want to try something you're even just a 
little bit unsure about.

In other words, creating a branch is like saving your game before you battle 
the boss.

If you want to see which specific SHA a branch points to, you can use a Git
plumbing tool called **rev-parse**. 

    $ git rev-parse topic1
    ca82a6dff817ec66f44342007202690a93763949
	
Merge
-----
[top](#content)

When merging one branch into another **git merge** will apply all the commits 
from the branch being merged from to the branch being merged into since the two 
diverged. You can consider it as forming a new head that contains the latest 
state from both of the branches put together. If you have changed a file in a 
branch and you merge it back into it's parent then the changes will be applied 
on top of the current state of that branch. If both files have changed in the 
same place then merge may not be able to resolve this and you will have to 
intervene. Usually though you just end up with the latest work from both branches.

To merge another branch into your active branch (e.g. master), use

**git merge [branch]**

Generally, the following rule of thumb can be used: Use rebase if you have a 
local branch with no other branches that have branched off from it, and use 
merge for all other cases. merge is also useful when you’re ready to pull your 
local branch’s changes back into the main branch.

If you do make changes to new-branch and then decide you want it to become your new
master branch, run the following commands:

	$ git branch -D master # goodbye old master (still in reflog)
	$ git branch -m new-branch master # the new-branch is now my master
	
Ordinarily, a commit has exactly one parent commit, namely, the previous commit. 
Merging branches together produces a commit with at least two parents. This begs 
the question: what commit does HEAD~10 really refer to? A commit could have 
multiple parents, so which one do we follow?

It turns out this notation chooses the first parent every time. This is desirable 
because the current branch becomes the first parent during a merge; frequently 
you’re only concerned with the changes you made in the current branch, as opposed 
to changes merged in from other branches.

You can refer to a specific parent with a caret. For example, to show the logs 
from the second parent:
	$ git log HEAD^2
You may omit the number for the first parent. For example, to show the 
differences with the first parent:
	$ git diff HEAD^
	
You can combine this notation with other types. For example:
	$ git checkout 1b6d^^2~10 -b ancient
starts a new branch “ancient” representing the state 10 commits back from the 
second parent of the first parent of the commit starting with 1b6d.

*********

Eventually, Part I is approved:

	$ git checkout master  # Go back to Part I.
	$ submit files         # Release to the world!
	$ git merge part2      # Merge in Part II.
	$ git branch -d part2  # Delete "part2" branch.
	
Now you’re in the master branch again, with Part II in the working directory.

It’s easy to extend this trick for any number of parts. It’s also easy to branch 
off retroactively: suppose you belatedly realize you should have created a 
branch 7 commits ago. Then type:

	$ git branch -m master part2  # Rename "master" branch to "part2".
	$ git branch master HEAD~7    # Create new "master", 7 commits upstream.
	
The master branch now contains just Part I, and the part2 branch contains the rest. 
	
	
Cherry-pick
-----------

Perhaps you like to work on all aspects of a project in the same branch. You 
want to keep works-in-progress to yourself and want others to see your commits 
only when they have been neatly organized. Start a couple of branches:

	$ git branch sanitized    # Create a branch for sanitized commits.
	$ git checkout -b medley  # Create and switch to a branch to work in.
	
Next, work on anything: fix bugs, add features, add temporary code, and so forth, 
committing often along the way. Then:

	$ git checkout sanitized
	$ git cherry-pick medley^^
	
applies the grandparent of the head commit of the “medley” branch to the "sanitized" 
branch. With appropriate cherry-picks you can construct a branch that contains only 
permanent code, and has related commits grouped together.

git cherry-pick SHA1

git cherry-pick --edit SHA1 - to change the commit message
git cherry-pick --no-commit SHA of commit1 SHA of commit2 - take two commits and
apply them but without commiting.

git cherry-pick -x SHA - insert into the commit message from where it is 
cherry-picked (only useful the cherry-picking from public branches)

--singoff - write down who cherry-picked the commit
	
	
Rebase
------

### Rebase for two branches:

What it does is that is takes the commits after the common commit from the two
branches, replays the commit from the other branch after the common commit and
then replays the commits from the current branch after the commits of the ohter
branch.

So `checkout current_branch` `rebase other_branch` will make the history of the
current branch like this:

commits from the current branch after the commit commits  
commits from the other branch after the commit commits  
common commits

**master branch** 

	cd853a0 Fix pluralization.
	b37fb82 Add index.
	c60de92 Catalog pages

**unicorns branch**

	b36b0b1 Add rainbows.
	423b4fb Add unicorns.
	c60de92 Catalog pages
    
then rebase:
	
	git checkout unicorns
	Switched to branch 'unicorns'
	$ git rebase master
	
**unicorns branch**

	30fadd8 Add rainbows.
	f1616a7 Add unicorns.
	cd853a0 Fix pluralization.
	b37fb82 Add index.
	c60de92 Catalog pages

**master branch** 

	cd853a0 Fix pluralization.
	b37fb82 Add index.
	c60de92 Catalog pages

### Interactive rebase for one branch
	
`git rebase -i HEAD~3`

It will open the commits after the specified commit (after HEAD~3 in the case).

git rabase -i HEAD will not have commits, because there is no commit after HEAD.

The order of commits is from oldest to newest (the oldest is on the top).

For reordering commits just change their order in the editor.
For changed the commit message - reword before the commit.


Bisect
------

You’ve just discovered a broken feature in your program which you know for sure 
was working a few months ago. Argh! Where did this bug come from? If only you 
had been testing the feature as you developed. It’s too late for that now. 
However, provided you’ve been committing often, Git can pinpoint the problem:

	$ git bisect start
	$ git bisect bad HEAD
	$ git bisect good 1b6d
	
Git checks out a state halfway in between. Test the feature, and if it’s still 
broken:

	$ git bisect bad
	
If not, replace "bad" with "good". Git again transports you to a state halfway 
between the known good and bad versions, narrowing down the possibilities. After 
a few iterations, this binary search will lead you to the commit that caused the 
trouble. Once you’ve finished your investigation, return to your original state 
by typing:

	$ git bisect reset
	
Instead of testing every change by hand, automate the search by running:

	$ git bisect run my_script
	
Tags
----
[top](#content)

Git uses two main types of tags: lightweight and annotated. A lightweight tag is
very much like a branch that doesn’t change - it’s just a pointer to a specific
commit. Annotated tags, however, are stored as full objects in the Git database. 
They’re checksummed; contain the tagger name, e-mail, and date; have a tagging 
message; and can be signed and verified with GNU Privacy Guard (GPG). It’s 
generally recommended that you create annotated tags so you can have all this 
information; but if you want a temporary tag or for some reason don’t want to
keep the other information, lightweight tags are available too.

A tag-name alias is identical to a branch alias in terms of naming a commit. 
The major difference between the two is that tag aliases never change, whereas 
branch aliases change each time a new commit is checked in to that branch.

If you get to a point that is important and you want to forever remember that 
specific commit snapshot, you can tag it with git tag. The tag command will 
basically put a permanent bookmark at a specific commit so you can use it 
to compare to other commits in the future. This is often done when you cut 
a release or ship something.

- **git tag v2.5 1b2e1d63ff** - giving a name to a commit (lightweight tag) 
  This is basically the commit checksum stored in a file — no other information 
  is kept.

  This creates a tag that doesn’t actually add a Tag object to the database, but 
  just creates a reference to it in the ‘.git/refs/tags’ directory. If you run
  the following command: `$ git tag v0.1`, Git will create the same file as 
  before, ‘.git/refs/tags/v0.1’, but it will contain the SHA-1 of the current 
  HEAD commit itself, not the SHA-1 of a Tag object pointing to that commit. 
  Unlike object Tags, these can be moved around easily, which is generally 
  undesirable.

- **git tag -a v1.0** ( **git tag [name-of-tag]** ) - add a tag

- **git tag -a v0.9 558151a(SHA)** add a tag to a previous commit

- **git tag** - see all tags

- **--decorate** - see your tags in **git log**

- :exclamation:   **v1.0^ <=> v1.0~1** and both mean "the parent of v1.0" 

Tags pointing to objects tracked from branch heads will be automatically 
downloaded when you fetch from a remote repository. However, tags that aren't 
reachable from branch heads will be skipped. If you want to make sure all tags 
are always included, you must include the **--tags** option.

**git push --tags** - to push the tags, too, otherwise they remain locally

**git push origin v1.5** - to push only concrete tag

git push [remote] --all - push all branches

If you just want a single tag, use **git fetch [remote] tag [tag-name]**.

By default, tags are not included when you push to a remote repository. 
In order to explicitly update these you must include the **--tags** option 
when using git push.
	
	
Push Local Repo to GitHub
-------------------------
[top](#content)

**git push [alias] [branch]**

To push your local repo to the GitHub server you'll need to add a remote repository. 
This command takes a remote name and a repository URL:

**git remote add origin git@github.com:[username]/[project].git** 

The push command tells Git where to put our commits when you're ready. So let's push your 
local changes to our origin repo (on GitHub). The name of your remote is origin and the 
default local branch name is master. The `-u` tells Git to remember the parameters, so that 
next time you can simply run git push and Git will know what to do.

**git push -u origin master**

The last major issue you run into with pushing to remote branches is the case 
of someone pushing in the meantime. If you and another developer clone at the 
same time, you both do commits, then she pushes and then you try to push, Git 
will by default not allow you to overwrite her changes. Instead, it basically 
runs git log on the branch you're trying to push and makes sure it can see 
the current tip of the server's branch in your push's history. If it can't 
see what is on the server in your history, it concludes that you are out of 
date and will reject your push. You will rightly have to fetch, merge then 
push again - which makes sure you take her changes into account.	


git remote
----------
[top](#content)

So that you don't have to use the full URL of a remote repository every time 
you want to synchronize with it, Git stores an alias or nickname for each 
remote repository URL you are interested in. You use the git remote command 
to manage this list of remote repos that you care about.

- **git remote show [alias]**
- **git remote** - list your remote aliases
- **git remote -v** - see the actual URL for each remote alias
- **git remote add [alias] [url]** - add a new remote repository of your project

		$ git remote add github git@github.com:schacon/hw.git
		
	Like the branch naming, remote alias names are arbitrary - just as 'master' 
	has no special meaning but is widely used because git init sets it up by 
	default, 'origin' is often used as a remote name because git clone sets 
	it up by default as the cloned-from URL. In this case we'll name the 
	remote 'github', but you could name it just about anything.
	
- **git remote rm [alias]** - removing an existing remote alias

- **git remote rename [old-alias] [new-alias]** - rename remote aliases

- **git remote set-url [alias] [new-url]** - update an existing remote URL

- **git remote set-url --push [alias] [new-url]** - set a different push URL

	This allows you to fetch from one repo while pushing to another and yet 
	both use the same remote alias.
	
	
git clone
---------
[top](#content)

Cloning automatically creates a remote connection called origin pointing back 
to the original repository. This makes it very easy to interact with a central 
repository.

**git clone https://github.com/[username]/[repository-name].git [destination-folder]**

	
git fetch
---------
[top](#content)

**git fetch [alias]** downloads new branches and data from a remote repository

**git fetch [alias]** will synchronize you with another repo, pulling down any data 
that you do not have locally and giving you bookmarks to where each branch 
on that remote was when you synchronized. These are called "remote branches" 
and are identical to local branches except that Git will not allow you to check 
them out - however, you can merge from them, diff them to other branches, run 
history logs on them, etc. You do all of that stuff locally after you 
synchronize.

**git fetch [alias] [branch]**


git pull
--------
[top](#content)

**git pull** will basically run a git fetch immediately followed by a git merge 
of the branch on that remote that is tracked by whatever branch you are 
currently in. Running the fetch and merge commands separately involves less 
magic and less problems.

	git fetch [alias]
	git merge [alias]/[branch]
	
git pull --rebase [remote] - git fetch and then git rebase
	
	
Man pages & Help
----------------
[top](#content)

**git help command**


Aliases
-------
[top](#content)

	git config --list

- **.gitconfig**

		[alias]
		  co = checkout
		  ci = commit
		  st = status
		  br = branch
		  hist = log --pretty=format:'%h %ad | %s%d [%an]' --graph --date=short
		  type = cat-file -t
		  dump = cat-file -p
	  
- **.profile**
  
		alias gs='git status '
		alias ga='git add '
		alias gb='git branch '
		alias gc='git commit'
		alias gd='git diff'
		alias go='git checkout '
		alias gk='gitk --all&'
		alias gx='gitx --all'

		alias got='git '
		alias get='git '
		

Internals
---------
[top](#content)

**.git/config** is a project-specific configuration file. Config entries in 
here will override the config entries in the .gitconfig file in your home 
directory, at least for this project.	

Internally, Git shares a strikingly similar structure to a filesystem, albeit 
with one or two key differences. First, it represents your file’s contents in
**blobs**, which are also leaf nodes in something awfully close to a directory, 
called a **tree**. A blob is named by computing the SHA1 hash id of its size and 
contents.

Thee fact that data is immutable in theit repository is what makes all of this 
work.

	$ git cat-file -t af5626b
	blob
	$ git cat-file blob af5626b
	Hello, world!
	
Thee contents of your files are stored in blobs, but those blobs are pretty 
featureless. They have no name, no structure — they’re just “blobs”, after all.

In order for Git to represent the structure and naming of your files, it 
attaches blobs as leaf nodes within a tree.

Blobs are created by stuffing the contents of your files into blobs — and trees 
own blobs.

The same file will always result in the same blob.

A branch is nothing more than a named reference to a commit. In this way,
branches and tags are identical, with the sole exception that tags can have 
their own descriptions, just like the commits they reference. Branches are just 
names, but tags are descriptive, well, “tags”.

To Git, the world is simply a collection of commit objects, each of which holds 
a tree that references other trees and blobs, which store your data. Anything
more complicated than this is simply a device of nomenclature.

![commits, trees and blobs](https://dl-web.dropbox.com/get/Just%20storage/git.jpg?w=AABCemccJL6lha34q-e0UMUTfCTSUT9uA94DgwcDiXnLGQ)

![one more time](http://git-scm.com/figures/18333fig0301-tn.png)

![commits](http://git-scm.com/figures/18333fig0302-tn.png)

Until now we’ve described two ways in which blobs find their way into Git: first 
they’re created in your index, both without a parent tree and without an owning 
commit; and then they’re committed into the repository, where they live as 
leaves hanging off of the tree held by that commit. But there are two other ways 
a blob can dwell in your repository: reflog and stash.


*********
*********
*********

**Rewrite history:**

git filter-branch --tree-filter [command]

git filter-branch --tree-filter 'rm -f passwords.txt' -- --all - in all branches
git filter-branch --tree-filter 'rm -f passwords.txt' -- HEAD - in the current branch
				  --index-filter 'WITH GIT COMMAND!: git rm --cached..'
--prune-empty - delete empty commits				

git branch name of branch SHA  

**********

 **git fsck --full** - shows all objects that aren’t pointed to by another object 
