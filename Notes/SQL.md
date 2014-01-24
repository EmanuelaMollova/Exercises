Content
=======

1. [**Primary Key**](#primary-key)
2. [**Foreign Key**](#foreign-key)
3. [**Relationships**](#relationships)
4. [**Normalization**](#normalization)
5. [**Nulls**](#nulls)
6. [**SELECT**](#select)
 - [AS](#as)
 - [DISTINCT](#distinct)
 - [ORDER BY](#order-by)
 - [WHERE](#where)
 - [AND, OR, NOT](#and)
 - [DEBUG](#debug)
 - [LIKE](#like)
 - [BETWEEN](#between)
 - [IN](#in)
 - [IS NULL](#is-null)
7. [**Operators and Functions**](#operators-and-functions)
 - [Concatenation](#concatenation)
 - [SUBSTRING](#substring)
 - [TRIM](#trim)
 - [POSITION](#position)
 - [CAST](#cast)
 - [CASE](#case)
 - [COALESCE](#coalesce)
 - [NULLIF](#nullif)
8. [**Aggregate Functions**](#aggregate-functions)
 - [DISTINCT](#distinct)
 - [GROUP BY](#group-by)
 - [HAVING](#having)
 - [Aliases](#aliases)
9. [**JOINS**](#joins)
 - [USING](#using)
 - [CROSS JOIN](#cross-join)
 - [NATURAL JOIN](#natural-join)
 - [INNER JOIN](#inner-join)
 - [OUTER JOIN](#outer-join)
 - [SELF JOIN](#self-join)
10. [**Subqueries**](#subqueries)
 - [ALL](#all)
 - [ANY](#any)
 - [EXISTS](#exist)
11. [**Set Opetations**](#set-operations)
12. [**INSERT**](#insert)
13. [**UPDATE**](#update)
14. [**DELETE**](#delete)
15. [**Creating tables**](#creating-tables)
 - [Constraints](#constraints)
 - [Primary Key](#primary-key-1)
 - [Foreign Key](#foreign-key-1)
 - [UNIQUE](#unique)
 - [CHECK](#check)
 - [Temporary Tables](#temporary-tables)
 - [CREATE TABLE AS](#create-table-as)
16. [**ALTER TABLE**](#alter-table)
17. [**DROP TABLE**](#drop-table)
18. [**Indexes**](#indexes)
19. [**Views**](#views)
20. [**Transactions**](#transactions)
21. [**Tricks**](#tricks)
 - [Calculating Running Statistics](#calculating-running-statistics)
 - [Generating Sequences](#generating-sequences)
 - [LIMIT](#limit)
 - [Calculating a Trimmed Mean](#calculating-a-trimmed-mean)
 - [Picking Random Rows](#picking-random-rows)
 - [Selecting Every nth Row](#selecting-every-nth-row)
 - [Metadata](#metadata)
 - [Working with Dates](#working-with-dates)


Primary Key
===========
[top](#content)

- **Required.** Every table has exactly one primary key.
- **Unique.**
- **Simple or composite.** A primary key has one or more columns in a table; a
one-column key is called a simple key, and a multiple-column key is called a
composite key.
- **Not null.** A primary-key value can’t be empty. For composite keys, no
column’s value can be empty;
- **Stable.** Once created, a primary-key value seldom if ever changes. If an
entity is deleted, its primary-key value isn’t reused for a new entity.
- **Minimal.** A primary key includes only the column(s) necessary for uniqueness.

Foreign Key
===========
[top](#content)

- It’s a column (or group of columns) in a table whose values relate to, or
reference, values in some other table.
- It ensures that rows in one table have corresponding rows in another table.
- The table that contains the foreign key is the **referencing** or **child table**.
The other table is the **referenced** or **parent table**.
- A foreign key establishes a direct relationship to the parent table’s primary
key (or any candidate key), so foreign-key values are restricted to existing
parent-key values.
- The values in the foreign key have the same domain as the parent key.
- Unlike primary-key values, foreign-key values can be null (empty);
- A foreign key can have a different column name than its parent key.
- Foreign-key values generally aren’t unique in their own table.
- In reality, a foreign key can reference the primary key of its own table
(rather than only some other table). A table employees with the primary key
`emp_id` can have a foreign key `boss_id,` for example, that references the column
`emp_id.` This type of table is called self-referencing.
- A foreign key column doesn’t have to reference only a primary key column in
another table; it also can reference a UNIQUE column in another table.
- A table can have any number of foreign key constraints (or none at all).

Relationships
=============
[top](#content)

###One-to-One

In a one-to-one relationship, each row in table A can have at most one matching
row in the table B, and each row in table B can have at most one matching row in
table A.

A one-to-one relationship is established when the primary key of one table also
is a foreign key referencing the primary key of another table.

###One-to-Many

In a one-to-many relationship, each row in table A can have many (zero or more)
matching rows in table B, but each row in table B has only one matching row in
table A.  A publisher can publish many books, but each book is published by only
one publisher, for example.

One-to-many relationships are established when the primary key of the one table
appears as a foreign key in the many table.

###Many-to-Many

In a many-to-many relationship, each row in table A can have many (zero or more)
matching rows in table B, and each row in table B can have many matching rows in
table A. Each author can write many books, and each book can have many authors,
for example.

A many-to-many relationships is established only by creating a third table
called a junction table, whose composite primary key is a combination of both
tables’ primary keys; each column in the composite key separately is a foreign
key. This technique always produces a unique value for each row in the junction
table and splits the many-to-many relationship into two separate one-to-many
relationships.

Normalization
=============
[top](#content)

First normal form
-----------------

A table in first normal form:
- Has columns that contain only atomic values
- Has no repeating groups

An atomic value, also called a scalar value, is a single value that can’t be
subdivided . A repeating group is a set of two or more logically related columns.
To fix these problems, store the data in two related tables.

Second normal form
------------------

A 1NF table automatically is in 2NF if:
- Its primary key is a single column (that is, the key isn’t composite)
or
- All the columns in the table are part of the primary key (simple or composite)

A table in second normal form:
- Is in first normal form
and
- Has no partial functional dependencies A table contains a partial functional
dependency if some (but not all) of a composite key’s values determine a nonkey
column’s value.

A 2NF table is fully functionally dependent, meaning that a nonkey column’s
value might need to be updated if any column values in the composite key change.

For each nonkey column, ask, “Can I determine a nonkey column value if I know only
part of the primary-key value?” A no answer means the nonkey column is fully
functionally dependent (good); a yes answer means that it’s partially functionally
dependent (bad).

| title_authors |
|---------------|
| title_id      |
| au_id         |
| au_order      |
| au_phone      |

`au_phone` depends on `au_id` but not `title_id,` so this table contains a partial
functional dependency and isn’t in 2NF.

For the column au_order, the questions are:
- Can I determine `au_order` if I know only `title_id`? No, because there might be
more than one author for the same title.
- Can I determine `au_order` if I know only `au_id`? No, because I need to know the
particular title too.

Good — `au_order` is fully functionally dependent and can remain in the table.
This dependency is written {title_id, au_id} -> {au_order}
and is read “title_id and au_id determine au_order” or “au_order depends on
title_id and au_id.” The determinant is the expression to the left of the arrow.

For the column `au_phone,` the questions are:
- Can I determine `au_phone` if I know only `title_id`? No, because there might be
more than one author for the same title.
- Can I determine `au_phone` if I know only `au_id`? Yes! The author’s phone number
doesn’t depend upon the title.

Bad — `au_phone` is partially functionally dependent and must be moved elsewhere
(probably to an authors or phone_numbers table) to satisfy 2NF rules.

Third normal form
-----------------

A table in third normal form:
- Is in second normal form
and
- Has no transitive dependencies

A table contains a transitive dependency if a nonkey column’s value determines
another nonkey column’s value. In 3NF tables, nonkey columns are mutually
independent and dependent on only primary-key column(s).

For each nonkey column, ask, “Can I determine a nonkey column value if I know any
other nonkey column value?” A no answer means that the column is not transitively
dependent (good); a yes answer means that the column whose value you can determine
is transitively dependent on the other column (bad).

| titles   |
|----------|
| title_id |
| price    |
| pub_city |
| pub_id   |

For the column `price,` the questions are:
- Can I determine `pub_id` if I know
price? No.
- Can I determine `pub_city` if I know
price? No.

For the column `pub_city,` the questions are:
- Can I determine `price` if I know `pub_city`? No.
- Can I determine `pub_id` if I know `pub_city`? No, because a city might have many
publishers.

For the column `pub_id,` the questions are:
- Can I determine price if I know `pub_id`? No.
- Can I determine `pub_city` if I know `pub_id`? Yes! The city where the book is
published depends on the publisher.

Bad — `pub_city` is transitively dependent on `pub_id` and must be moved elsewhere
(probably to a publishers table) to satisfy 3NF rules.

As you can see, it’s not enough to ask, “Can I determine A if I know B?” to
discover a transitive dependency; you also must ask, “Can I determine B if I know A?”

##### Comments: --

##### Test against standard

To test your SQL code against the standard, go to [http://developer.mimer.se/]
(http://developer.mimer.se/) validator and click the validator link for the SQL
1992, 1999, or 2003 standard.

##### Escape single quote in strings

Two consecutive single quotes represent one single-quote character in a string.
Type `‘don’’t’` to represent don’t, for example. A double-quote character (“)
is a separate character and doesn’t need this special treatment.

Nulls
=====
[top](#content)

- Although nulls are never equal to each other, DISTINCT treats all the nulls in
a particular column as duplicates;
- Nulls propagate through computations.  The result of any arithmetic expression
or operation that involves a null is null: (12*NULL)/4 is null;
- Most aggregate functions, such as SUM(), AVG(), and MAX(), ignore nulls. COUNT(*)
is an exception.
- If the grouping column in a GROUP BY clause contains nulls, all the nulls are
put in a single group;
- Nulls affect the results of joins;
- Nulls can cause problems in subqueries
- If nulls appear in a column because actual values are not meaningful (rather
than unknown), you can split the column off into its own table with a one-to-one
relationship with the other table.

Select
======
[top](#content)

Simple SELECT
-------------

    SELECT column / columns / *
    FROM table;

AS
--

    SELECT column1 [AS] alias1,
    column2 [AS] alias2,
    ...
    columnN [AS] aliasN
    FROM table;

DISTINCT
--------
[top](#content)

To eliminate duplicate rows:

    SELECT DISTINCT columns
    FROM table;

- If the SELECT DISTINCT clause contains more than one column, the values of
all the columns combined determine the uniqueness of rows.

- Although nulls never equal each other because their values are unknown,
DISTINCT considers all nulls to be duplicates of each other. SELECT DISTINCT
returns only one null in a result, regardless of how many nulls it encounters.

- The SELECT statement syntax includes the optional ALL keyword. You rarely see
ALL in practice because it denotes the default behavior: display all rows,
including duplicates.

        SELECT columns FROM table;

is equivalent to:

    SELECT ALL columns FROM table;

The syntax diagram is:

    SELECT [ALL | DISTINCT] columns
    FROM table;

-If a table has a properly defined primary key, `SELECT DISTINCT * FROM table;`
and `SELECT * FROM table;` return identical results because all rows are unique.

- For DISTINCT operations, the DBMS performs an internal sort to identify and
remove duplicate rows. Sorting is computationally expensive—don’t use DISTINCT
unless you have to do so.

ORDER BY
--------
[top](#content)

    SELECT columns
    FROM table
    ORDER BY sort_column [ASC | DESC];

If no sort direction is specified, ASC is assumed (low to highest).

    SELECT au_fname, au_lname, city, state
    FROM authors
    ORDER BY 4 ASC, 2 DESC;

    select au_id, phone
    from authors
    order by
    substr(phone, length(phone)-3);

- You can sort by columns that aren’t listed in the SELECT clause. This
technique won’t work for relative column positions.
- You can specify column aliases instead of column names in ORDER BY.

        SELECT title_id, type, price, sales
        FROM titles
        ORDER BY CASE WHEN type = 'history'
        THEN price ELSE sales END;

- You should create indexes for columns that you sort frequently.

Sort by Expression
------------------

    SELECT title_id,
    price,
    sales,
    price * sales AS "Revenue"
    FROM titles
    ORDER BY "Revenue" DESC;

WHERE
-----
[top](#content)

### Types of Conditions

| Condition        | SQL Operators       |
|------------------|---------------------|
| Comparison       | =, <>, <, <=, >, >= |
| Pattern matching | LIKE                |
| Range filtering  | BETWEEN             |
| List filtering   | IN                  |
| Null testing     | IS NULL             |

### Comparison Operators

| Operator | Description              |
|----------|--------------------------|
|  =       | Equal to                 |
|  <>      | Not equal to             |
|  <       | Less than                |
|  <=      | Less than or equal to    |
|  >       | Greater than             |
|  >=      | Greater than or equal to |

- For speed, fold your constants into a minimal number of expressions. For
example, change

        WHERE col1 + 2 <= 10

to

    WHERE col1 <= 8

The best practice is to put only simple column references to the left of the =
and more-complex expressions to the right.

- In general, the fastest comparison is for equality (=), following by the
inequalities (<, <=, >, >=). The slowest is not-equal (<>). If possible, express
your conditions by using faster comparisons.

- You can’t use an aggregate function such as SUM() or COUNT() in a WHERE clause.

- If you alias a column in a SELECT clause, you can’t reference it in the WHERE
clause. The following query fails because the WHERE clause is evaluated before
the SELECT clause, so the alias copies_sold doesn’t yet exist when the WHERE
clause is evaluated:

        -- Wrong
        SELECT sales AS copies_sold
        FROM titles
        WHERE copies_sold > 100000;

Instead, use a subquery (Chapter 8) in the FROM clause, which is evaluated before
the WHERE clause:

    -- Correct
    SELECT *
    FROM (SELECT sales AS copies_sold
    FROM titles) ta
    WHERE copies_sold > 100000;

### AND

List the authors whose last names begin with one of the letters H through Z and
who don’t live in California.

    SELECT au_fname, au_lname
    FROM authors
    WHERE au_lname >= 'H'
    AND au_lname <= 'Zz'
    AND state <> 'CA';

### OR

The following will not display the records with state = NULL

    SELECT pub_id, pub_name, state, country
    FROM publishers
    WHERE (state = 'CA')
    OR (state <> 'CA');

**NOT** is evaluated first, then **AND**, and finally **OR**.

### Debug

    SELECT type,
    type = ‘history’ AS “Hist?”,
    type = ‘biography’ AS “Bio?”,
    price,
    price < 20 AS “<20?”
    FROM titles;

### Equivalent Conditions

| This Condition | Is Equivalent To       |
|----------------|------------------------|
| NOT (NOT p)    | p                      |
| NOT (p AND q)  | (NOT p) OR (NOT q)     |
| NOT (p OR q)   | (NOT p) AND (NOT q)    |
| p AND (q OR r) | (p AND q) OR (p AND r) |
| p OR (q AND r) | (p OR q) AND (p OR r)  |

LIKE
----
[top](#content)

- LIKE works with only character strings, not numbers or datetimes.

### Wildcard Operators

| Operator | Matches                                                       |
|----------|---------------------------------------------------------------|
| %        | A percent sign matches any string of zero or more characters. |
| _        | An underscore matches any one character.                      |

    SELECT title_name
    FROM titles
    WHERE title_name LIKE '%!%%' ESCAPE '!';

### Examples of [] and [^] Patterns

| Pattern   | Matches                                                                             |
|-----------|-------------------------------------------------------------------------------------|
| ‘[a-c]at’ | Matches ‘bat’ and ‘cat’ but not ‘fat’.                                              |
| ‘[bcf]at’ | Matches ‘bat’, ‘cat’, and ‘fat’ but not ‘eat’.                                      |
| ‘[^c]at’  | Matches ‘bat’ and ‘fat’ but not ‘cat’.                                              |
| ‘se[^n]%’ | Matches strings of length ≥ 2 that begin with se and whose third character isn’t n. |

BETWEEN
-------
[top](#content)

- BETWEEN works with character strings, numbers, and datetimes.
- BETWEEN specifies an inclusive range.

        SELECT title_id, price
        FROM titles
        WHERE price BETWEEN 10 AND 19.95;

IN
--
[top](#content)

    WHERE test_column IN
    (value1, value2, value3)

is equivalent to:

    WHERE (test_column = value1)
    OR (test_column = value2)
    OR (test_column = value3)

The search condition

    WHERE col1 BETWEEN 1 AND 5
    AND col1 <> 3

usually is faster than

    WHERE col1 IN (1, 2, 4, 5)

IS NULL
-------
[top](#content)

LIKE, BETWEEN, IN, and other WHERE-clause conditions can’t find nulls because
unknown values don’t satisfy specific conditions.

- IS NULL works for columns of any data type.
- You can negate an IS NULL condition with IS NOT NULL.
- You can combine IS NULL conditions and other conditions with AND and OR.

        SELECT columns
        FROM table
        WHERE test_column IS [NOT] NULL;

Operators and Functions
=======================
[top](#content)

Closure guarantees that every result is a table.

    SELECT au_id, 2 + 3
    FROM authors;

    au_id 2 + 3
    ----- -----
    A01 5
    A02 5
    A03 5
    A04 5
    A05 5
    A06 5
    A07 5

    SELECT title_id,
    price,
    0.10 AS "Discount",
    price * (1 - 0.10) AS "New price"
    FROM titles;

Concatenation
-------------

`||`


    SELECT au_fname || ' ' || au_lname

In MySQL: **CONCAT()** takes any number of arguments and converts nonstrings to
strings as necessary.

Substring
---------

    SUBSTRING(string FROM start [FOR length])

MySQL and PostgreSQL also support the SUBSTR(string, start, length) form of the
substring function.

    UPPER(string)
    LOWER(string)

Trim
----

    TRIM([[LEADING | TRAILING | BOTH] FROM] string)

    SELECT au_lname,
    TRIM(LEADING 'H' FROM au_lname)
    AS "Trimmed name"
    FROM authors;

    CHARACTER_LENGTH(string)

POSITION()
----------
[top](#content)

- POSITION() returns an integer (>= 0)  that indicates the starting position of
a substring’s first occurrence within a string.
- If the string doesn’t contain the substring, POSITION() returns zero.
- If any argument is null, POSITION() returns null.

        REPLACE()

        YEAR(pubdate)
        MONTH(pubdate)

        CURRENT_DATE
        CURRENT_TIME
        CURRENT_TIMESTAMP

CAST()
------

CAST(expr AS data_type)

    SELECT
    price
    AS "price(DECIMAL)",
    CAST(price AS INTEGER)
    AS "price(INTEGER)",
    '<' || CAST(price AS CHAR(8)) || '>'
    AS "price(CHAR(8))"
    FROM titles;

CASE()
------
[top](#content)

Used for example when we have numbers representing some things (1 - boy, 2 - girl)
and we want to display text.

    CASE comparison_value
    WHEN value1 THEN result1
    WHEN value2 THEN result2
    ...
    WHEN valueN THEN resultN
    [ELSE default_result]
    END

    SELECT
    title_id,
    type,
    price,
    CASE type
    WHEN 'history'
    THEN price * 1.10
    WHEN 'psychology'
    THEN price * 1.20
    ELSE price
    END
    AS "New price"
    FROM titles
    ORDER BY type ASC, title_id ASC;

    SELECT
    title_id,
    CASE
    WHEN sales IS NULL
    THEN 'Unknown'
    WHEN sales <= 1000
    THEN 'Not more than 1,000'
    WHEN sales <= 10000
    THEN 'Between 1,001 and 10,000'
    WHEN sales <= 100000
    THEN 'Between 10,001 and 100,000'
    WHEN sales <= 1000000
    THEN 'Between 100,001 and 1,000,000'
    ELSE 'Over 1,000,000'
    END
    AS "Sales category"
    FROM titles
    ORDER BY sales ASC;

    CASE
    WHEN n <> 0 THEN expr/n
    ELSE NULL
    END

Checking for Nulls with COALESCE()
----------------------------------

The function COALESCE() returns the first non-null expression among its
arguments.

    COALESCE(expr1, expr2, expr3)
    is equivalent to:
    CASE
    WHEN expr1 IS NOT NULL THEN expr1
    WHEN expr2 IS NOT NULL THEN expr2
    ELSE expr3
    END

To return the first non-null value:
    COALESCE(expr1, expr2,...)

Comparing Expressions with NULLIF()
----------------------------------

The function NULLIF() compares two expressions and returns null if they are
equal or the first expression otherwise.  NULLIF() typically is used to convert
a userdefined missing, unknown, or inapplicable value to null.

    NULLIF(expr1, expr2)
    is equivalent to:
    CASE
    WHEN expr1 = expr2 THEN NULL
    ELSE expr1
    END

    SELECT club_id, males, females,
    males/NULLIF(females,0)
    AS ratio
    FROM school_clubs;

To return a null if two expressions are equivalent:
    NULLIF(expr1, expr2)

NULLIF() compares expr1 and expr2.
If they are equal, the function returns null.
If they’re unequal, the function returns expr1.

Aggregate Functions
===================
[top](#content)

    MIN(expr)
    MAX(expr)
    SUM(expr)
    AVG(expr)
    COUNT(expr)
    COUNT(*)

**All aggregate functions except COUNT(*) ignore nulls.**

- An aggregate expression can’t appear in a WHERE clause.
- You can’t mix nonaggregate (row-by-row) and aggregate expressions in a SELECT
clause.
- You can use more than one aggregate expression in a SELECT clause.
- You can’t nest aggregate functions.
- You can use aggregate expressions in subqueries.

This statement finds the title of the book with the highest sales:

    SELECT title_id, price --Legal
    FROM titles
    WHERE sales =
    (SELECT MAX(sales) FROM titles);

- COUNT(expr) returns the number of rows in which expr is not null.
- COUNT(*) returns the count of all rows in a set, including nulls and duplicates.
- COUNT(*) - COUNT(expr) returns the number of nulls.

DISTINCT
--------
[top](#content)

    agg_func([ALL | DISTINCT] expr)

- DISTINCT in a SELECT clause and DISTINCT in an aggregate function don’t return
the same result.

        SELECT COUNT(au_id)
        AS "COUNT(au_id)"
        FROM title_authors;
    17

        SELECT DISTINCT COUNT(au_id)
        AS "DISTINCT COUNT(au_id)"
        FROM title_authors;
    17

        SELECT COUNT(DISTINCT au_id)
        AS "COUNT(DISTINCT au_id)"
        FROM title_authors;
    6

GROUP BY
--------
[top](#content)

The following counts the number of books that each author wrote (or cowrote):

    SELECT
    au_id,
    COUNT(*) AS "num_books"
    FROM title_authors
    GROUP BY au_id;

- The GROUP BY clause comes after the WHERE clause and before the ORDER BY clause.

        SELECT columns
        FROM table
        [WHERE search_condition]
        GROUP BY grouping_columns
        [HAVING search_condition]
        [ORDER BY sort_columns];

List the number of books of each type for each publisher, sorted by descending
count within ascending publisher ID.

    SELECT
    pub_id,
    type,
    COUNT(*) AS "COUNT(*)"
    FROM titles
    GROUP BY pub_id, type
    ORDER BY pub_id ASC, "COUNT(*)" DESC;

    pub_id type COUNT(*)
    ------ ---------- --------
    P01 biography 3
    P01 history 1
    P02 computer 1
    P03 history 2
    P03 biography 1
    P04 psychology 3
    P04 children 2

- Use the WHERE clause to exclude rows that you don’t want grouped and use the
HAVING clause to filter rows after they have been grouped.
- If used without an aggregate function, GROUP BY acts like DISTINCT.

HAVING
------
[top](#content)

- The HAVING clause sets conditions on the GROUP BY clause similar to the way that
WHERE interacts with SELECT.
- The WHERE search condition is applied before grouping occurs, and the HAVING
search condition is applied after.
- HAVING syntax is similar to the WHERE syntax, except that HAVING can contain
aggregate functions.

The sequence in which the WHERE, GROUP BY, and HAVING clauses are applied is:

1. The WHERE clause filters the rows that result from the operations specified
in the FROM and JOIN clauses.
2. The GROUP BY clause groups the output of the WHERE clause.
3. The HAVING clause filters rows from the grouped result.

        SELECT
        au_id,
        COUNT(*) AS "num_books"
        FROM title_authors
        GROUP BY au_id
        HAVING COUNT(*) >= 3;

Generally, a HAVING clause should involve only aggregates. The only conditions
that you specify in the HAVING clause are those conditions that must be applied
after the grouping operation has been performed.  It’s more efficient to specify
conditions that can be applied before the grouping operation in the WHERE clause.

    SELECT
    type,
    SUM(sales) AS "SUM(sales)",
    AVG(price) AS "AVG(price)"
    FROM titles
    WHERE pub_id IN ('P03', 'P04')
    GROUP BY type
    HAVING SUM(sales) > 10000
    AND AVG(price) < 20;

ALIASES
-------
[top](#content)

    table [AS] alias

    SELECT au_fname, au_lname, a.city
    FROM authors a
    INNER JOIN publishers p
    ON a.city = p.city;

- An alias name hides a table name. If you alias a table, you must use its alias
in all qualified references.

The following statement is illegal because the alias a occludes the table name
authors:

    SELECT authors.au_id
    FROM authors a; --Illegal

JOINS
-----
[top](#content)

Tables are joined row by row and side by side by satisfying whatever join
condition(s) you specify in the query.

### Types of Joins

- **Cross join** - returns all rows from the first table in which each row from
the first table is combined with all rows from the second table.
- **Natural join** - a join that compares, for equality, all the columns in the
first table with corresponding columns that have the same name in the second
table.
- **Inner join** - a join that uses a comparison operator to match rows from two
tables based on the values in common columns from each table. Inner joins are
the most common type of join.
- **Left outer join** - returns all the rows from the left table, not just the
matching rows in the right table, the associated result row contains nulls for
all SELECT-clause columns coming from the right table.
- **Right outer join** - the reverse of a left outer join. All rows from the
right table are returned. Nulls are returned for the left table if a right-table
row has no matching left-table row.
- **Full outer join** - returns all rows in both the left and right tables. If a
row has no match in the other table, the SELECT-clause columns from the other
table contain nulls. If there is a match between the tables, the entire result
row contains values from both tables.
- **Self- join** - a join of a table to itself.

        SELECT columns
        FROM table1 join_type table2
        ON join_conditions
        [WHERE search_condition]
        [GROUP BY grouping_columns]
        [HAVING search_condition]
        [ORDER BY sort_columns];

        SELECT au_fname, au_lname, a.city
        FROM authors a
        INNER JOIN publishers p
        ON a.city = p.city;

### Query Execution Sequence

1. Applies the join conditions in the JOIN clause.
2. Applies the join conditions and search conditions in the WHERE clause.
3. Groups rows according to the GROUP BY clause.
4. Applies the search conditions in the HAVING clause to the groups.
5. Sorts the result according to the ORDER BY clause.

### USING
[top](#content)

For JOIN syntax, the SQL standard also defines a USING clause that can be used
instead of the ON clause if the joined columns have the same name and are
compared for equality:

    FROM table1 join_type table2
    USING (columns)

    SELECT au_fname, au_lname, city
    FROM authors
    INNER JOIN publishers
    USING (city);

The USING clause acts like a natural join, except that you can use it if you don’t
want to join all pairs of columns with the same name in both tables. Note that
the preceding USING example joins only on the column city in both tables, whereas
a natural join would join on both the columns city and state common to the tables.

USING is a syntactic convenience that doesn’t add extra functionality to SQL. A USING clause
always can be replicated with an ON clause in JOIN syntax or with a WHERE clause in WHERE syntax.

MySQL requires the SELECT clause’s common column names to be qualified in USING
queries.  To run the preceding example, change city to authors.city in the SELECT
clause.

### CROSS JOIN
[top](#content)

- Returns all possible combinations of rows of two tables. The result contains all
rows from the first table; each row from the first table is combined with all
rows from the second table.
- Can produce a huge result, even with small tables. If one table has m rows and
the other has n rows, the result contains m x n rows.
- Also is called a Cartesian product or cross product.

        SELECT columns
        FROM table1
        CROSS JOIN table2

        SELECT authors.*, p.pub_id
        FROM authors
        CROSS JOIN publishers p;

### NATURAL JOIN
[top](#content)

- It compares all the columns in one table with corresponding columns that have
the same name in the other table for equality.
- Works only if the input tables have one or more pairs of meaningfully comparable,
identically named columns.
- It is a syntactic convenience that can be replicated explicitly with an ON clause
in JOIN syntax or a WHERE clause in WHERE syntax.

        SELECT columns
        FROM table1
        NATURAL JOIN table2

        SELECT
        title_id,
        pub_id,
        pub_name
        FROM publishers
        NATURAL JOIN titles;

### INNER JOIN
[top](#content)

    SELECT columns
    FROM table1
    INNER JOIN table2
    ON join_conditions

    SELECT columns
    FROM table1
    INNER JOIN table2
    ON join_condition1
    INNER JOIN table3
    ON join_condition2

    SELECT
    a.au_id,
    a.au_fname,
    a.au_lname,
    ta.title_id
    FROM authors a
    INNER JOIN title_authors ta
    ON a.au_id = ta.au_id
    ORDER BY a.au_id ASC, ta.title_id ASC;

        SELECT
        a.au_id,
        a.au_fname,
        a.au_lname,
        a.city,
        a.state
        FROM authors a
        INNER JOIN publishers p
        ON a.city = p.city
        AND a.state = p.state
        ORDER BY a.au_id;

is the same as

    SELECT a.au_id, a.au_fname,
    a.au_lname, a.city, a.state
    FROM authors a
    NATURAL JOIN publishers p
    ORDER BY a.au_id ASC;

    SELECT
    a.au_id,
    COUNT(ta.title_id) AS "Num books"
    FROM authors a
    INNER JOIN title_authors ta
    ON a.au_id = ta.au_id
    GROUP BY a.au_id
    ORDER BY a.au_id ASC;

### OUTER JOIN
[top](#content)

An inner join eliminates the rows that don’t match with a row from the other
table, whereas an outer join returns all rows from at least one of the tables.

Outer joins are useful for answering questions that involve missing quantities:
authors who have written no books or classes with no enrolled students, for
example.

All rows are retrieved from the left table referenced in a left outer join,
all rows are retrieved from the right table referenced in a right outer join,
and all rows from both tables are retrieved in a full outer join. In all cases,
unmatched rows are padded with nulls. In the result, you can’t distinguish the
nulls (if any) that were in the input tables originally from the nulls inserted
by the outerjoin operation.

    SELECT column
    FROM left_table
    LEFT|RIGHT|FULL [OUTER] JOIN right_table
    ON join_conditions

Microsoft Access and MySQL don’t support full outer joins, but you can replicate
one by taking the union of left and right outer joins.

    SELECT
    a.au_id,
    COUNT(ta.title_id) AS "Num books"
    FROM authors a
    LEFT OUTER JOIN title_authors ta
    ON a.au_id = ta.au_id
    GROUP BY a.au_id
    ORDER BY a.au_id ASC;

List the authors who haven’t written (or cowritten) a book.

    SELECT a.au_id, a.au_fname, a.au_lname
    FROM authors a
    LEFT OUTER JOIN title_authors ta
    ON a.au_id = ta.au_id
    WHERE ta.au_id IS NULL;

### SELF JOIN
[top](#content)

- A self-join is a normal SQL join that joins a table to itself and retrieves rows
from a table by comparing values in one or more columns in the same table.

- As with any join, a self-join requires two tables, but instead of adding a
second table to the join, you add a second instance of the same table. That way,
you can compare a column in the first instance of the table to a column in the
second instance.

        SELECT
        e1.emp_name AS "Employee name",
        e2.emp_name AS "Boss name"
        FROM employees e1
        INNER JOIN employees e2
        ON e1.boss_id = e2.emp_id;

List the authors who live in the same state as author A04.

    SELECT a1.au_id, a1.au_fname,
    a1.au_lname, a1.state
    FROM authors a1
    INNER JOIN authors a2
    ON a1.state = a2.state
    WHERE a2.au_id = 'A04';

Self-joins often can be restated as subqueries. Using a subquery, the above is
equivalent to:

    SELECT au_id, au_fname,
    au_lname, state
    FROM authors
    WHERE state IN
    (SELECT state
    FROM authors
    WHERE au_id = ‘A04’);

List all pairs of authors who live in New
York state.

    SELECT
    a1.au_fname, a1.au_lname,
    a2.au_fname, a2.au_lname
    FROM authors a1
    INNER JOIN authors a2
    ON a1.state = a2.state
    WHERE a1.state = 'NY'
    ORDER BY a1.au_id ASC, a2.au_id ASC;

Subquires
---------
[top](#content)

- Don’t put an ORDER BY clause in a subquery. (A subquery returns an intermediate
result that you never see, so sorting a subquery makes no sense.)
- A subquery is a single SELECT statement. (You can’t use, say, a UNION of
multiple SELECT statements as a subquery.)
- If a table appears in an inner query but not in the outer query, you can’t
include that table’s columns in the final result.

In practice, a subquery usually appears in a WHERE clause that takes one of these
forms:
- WHERE test_expr op (subquery)
- WHERE test_expr [NOT] IN (subquery)
- WHERE test_expr op ALL (subquery)
- WHERE test_expr op ANY (subquery)
- WHERE [NOT] EXISTS (subquery)

        SELECT au_id, au_fname, au_lname
        FROM authors
        WHERE au_id NOT IN
        (SELECT au_id FROM title_authors);

        SELECT title_id, price
        FROM titles
        WHERE price =
        (SELECT MAX(price)
        FROM titles);

- Favor subqueries if you’re comparing an aggregate value to other values. Without
a subquery, you’d need two SELECT statements.
- Use joins when you include columns from multiple tables in the result.

You can’t accomplish this same task with a subquery, because it’s illegal to
include a column in the outer query’s SELECT clause list from a table that appears
in only the inner query:

    SELECT a.au_id, a.city, p.pub_id
    FROM authors a
    WHERE a.city IN
    (SELECT p.city
    FROM publishers p); --Illegal

- A simple subquery, or noncorrelated subquery, is a subquery that can be
evaluated independently of its outer query and is processed only once for the
entire statement.

- A correlated subquery can’t be evaluated independently of its outer query; it’s
an inner query that depends on data from the outer query.
- It’s executed repeatedly—once for each candidate row selected by the outer query.
- It always refers to the table mentioned in the FROM clause of the outer query.
- The basic syntax of a query that contains a correlated subquery is:

        SELECT outer_columns
        FROM outer_table
        WHERE outer_column_value IN
        (SELECT inner_column
        FROM inner_table
        WHERE inner_column = outer_column)

        SELECT
        candidate.title_id,
        candidate.type,
        candidate.sales
        FROM titles candidate
        WHERE sales >=
        (SELECT AVG(sales)
        FROM titles average
        WHERE average.type = candidate.type);

        SELECT title_id,
        price,
        (SELECT AVG(price) FROM titles)
        AS "AVG(price)",
        price - (SELECT AVG(price) FROM titles)
        AS "Difference"
        FROM titles
        WHERE type='biography';

        SELECT MAX(ta.count_titles) AS “Max titles”
        FROM (SELECT COUNT(*) AS count_titles
        FROM title_authors
        GROUP BY au_id) ta;

        SELECT type, title_id, sales
        FROM titles t1
        WHERE sales <
        (SELECT MAX(sales)
        FROM titles t2
        WHERE t1.type = t2.type
        AND sales IS NOT NULL)
        ORDER BY type ASC, title_id ASC;

### All
[top](#content)

- When ALL is used with <, <=, >, or >=, the comparison is equivalent to evaluating
the subquery result’s minimum or maximum value.
- <> ALL is equivalent to NOT IN

        SELECT title_id, title_name
        FROM titles
        WHERE sales > ALL
        (SELECT sales
        FROM title_authors ta
        INNER JOIN titles t
        ON t.title_id = ta.title_id
        WHERE ta.au_id = 'A06'
        AND sales IS NOT NULL);

#### ALL Equivalencies

| ALL Expression  | Column Function        |
|-----------------|------------------------|
| < ALL(subquery) | < MIN(subquery values) |
| > ALL(subquery) | > MAX(subquery values) |

### Any
[top](#content)

#### ANY Equivalencies

| ANY Expression  | Column Function        |
|-----------------|------------------------|
| < ANY(subquery) | < MAX(subquery values) |
| > ANY(subquery) | > MIN(subquery values) |

    SELECT au_id, au_lname, au_fname, city
    FROM authors
    WHERE city = ANY
    (SELECT city
    FROM publishers);

= ANY is equivalent to IN, but <> ANY isn’t equivalent to NOT IN. If subquery
returns the values x, y, and z, test_expr <> ANY (subquery) is equivalent to:

    test_expr <> x OR
    test_expr <> y OR
    test_expr <> z

But test_expr NOT IN (subquery) is equivalent to:

    test_expr <> x AND
    test_expr <> y AND
    test_expr <> z

(NOT IN actually is equivalent to <> ALL.)

### Exists
[top](#content)

- An existence test doesn’t compare values, so it isn’t preceded by a test expression.
- By convention, the SELECT clause in the subquery is SELECT * to retrieve all
columns. Listing specific column names is unnecessary, because EXISTS simply
tests for the existence of rows that satisfy the subquery conditions; the actual
values in the rows are irrelevant.
- A subquery row that contains only nulls counts as a row. (An EXISTS test is true,
and a NOT EXISTS test is false.)
- Because an EXISTS test performs no comparisons, it’s not subject to the same
problems with nulls as tests that use IN, ALL, or ANY.

        SELECT pub_name
        FROM publishers p
        WHERE EXISTS
        (SELECT *
        FROM titles t
        WHERE t.pub_id = p.pub_id
        AND type = 'biography');

        SELECT au_id, au_fname, au_lname
        FROM authors a
        WHERE EXISTS
        (SELECT *
        FROM title_authors ta
        WHERE ta.au_id = a.au_id
        HAVING COUNT(*) >= 3);

- Although SELECT * is the most common form of the SELECT clause in an EXISTS
subquery, you can use SELECT column or SELECT constant_value to speed queries
if your DBMS’s optimizer isn’t bright enough to figure out that it doesn’t need
to construct an entire interim table for an EXISTS subquery.

Be careful when using aggregate functions in a subquery SELECT clause.

    SELECT pub_id
    FROM publishers
    WHERE EXISTS
    (SELECT COUNT(*)
    FROM titles
    WHERE pub_id = 'XXX');

Result:

    | pub_id |
    |--------|
    | P01    |
    | P02    |
    | P03    |
    | P04    |

***********

These six queries are equivalent semantically; they all list the authors who have
written (or cowritten) at least one book.

    SELECT DISTINCT a.au_id
    FROM authors a
    INNER JOIN title_authors ta
    ON a.au_id = ta.au_id;

    SELECT DISTINCT a.au_id
    FROM authors a, title_authors ta
    WHERE a.au_id = ta.au_id;

    SELECT au_id
    FROM authors a
    WHERE au_id IN
    (SELECT au_id
    FROM title_authors);

    SELECT au_id
    FROM authors a
    WHERE au_id = ANY
    (SELECT au_id
    FROM title_authors);

    SELECT au_id
    FROM authors a
    WHERE EXISTS
    (SELECT *
    FROM title_authors ta
    WHERE a.au_id = ta.au_id);

    SELECT au_id
    FROM authors a
    WHERE 0 <
    (SELECT COUNT(*)
    FROM title_authors ta
    WHERE a.au_id = ta.au_id);

Set Opetations
--------------
[top](#content)

### UNION

- UNION returns all the rows returned by both queries, with duplicates removed.
- A **UNION ALL** expression doesn’t remove duplicates.
- The SELECT-clause lists in the two queries must have the same number of columns
(column names, arithmetic expressions, aggregate functions, and so on).
- The corresponding columns in the two queries must be listed in the same order
in the two queries.
- An ORDER BY clause can appear in only the final query in the UNION statement.
The sort is applied to the final, combined result.
- GROUP BY and HAVING can be specified in the individual queries only; they can’t be
used to affect the final result.

        select_statement1
        UNION [ALL]
        select_statement2;

Don’t use UNION where a compound condition will suffice:

    SELECT DISTINCT * FROM mytable
    WHERE col1 = 1 AND col2 = 2;

usually is faster than

    SELECT * FROM mytable
    WHERE col1 = 1;
    UNION
    SELECT * FROM mytable
    WHERE col2 = 2;

### INTERSECT

- INTERSECT returns all rows common to both queries (that is, all distinct rows
retrieved by both queries).

        select_statement1
        INTERSECT
        select_statement2;

- It’s helpful to think of UNION as logical OR and INTERSECTION as logical AND.
- Microsoft Access, Microsoft SQL Server 2000, and MySQL don’t support INTERSECT.

### EXCEPT

- EXCEPT returns all rows from the first query without the rows that appear in the
second query, with duplicates removed.

        select_statement1
        EXCEPT
        select_statement2;

- Unlike UNION and INTERSECT, EXCEPT is not commutative: A EXCEPT B isn’t the
same as B EXCEPT A.
- Don’t use EXCEPT where a compound condition will suffice.
- Microsoft Access, Microsoft SQL Server 2000, and MySQL don’t support EXCEPT.

INSERT
------
[top](#content)

    INSERT INTO table
    VALUES(value1, value2, ..., valueN);

    INSERT INTO table
    (column1, column2, ..., columnN)
    VALUES(value1, value2, ..., valueN);

    INSERT INTO table
    [(column1, column2,..., columnN)]
    subquery;

    INSERT INTO publishers
    SELECT
    pub_id,
    pub_name,
    city,
    state,
    country
    FROM new_publishers
    WHERE city = 'Los Angeles';

UPDATE
------
[top](#content)

- UPDATE takes an optional WHERE clause that specifies which rows to update.
Without a WHERE clause, UPDATE changes all the rows in the table.
- UPDATE is dangerous because it’s easy to omit the WHERE clause mistakenly (and
update all rows) or misspecify the WHERE search condition (and update the wrong
rows). It’s wise to run a SELECT statement that uses the same WHERE clause before
running the actual UPDATE statement.

        UPDATE table
        SET column = expr
        [WHERE search_condition];

        UPDATE titles
        SET price = price * CASE type
        WHEN ‘history’ THEN 1.10
        WHEN ‘psychology’ THEN 1.20
        ELSE 1
        END;

DELETE
------
[top](#content)

Without a WHERE clause, DELETE removes all the rows in the table.

    DELETE FROM table
    [WHERE search_condition];

The following statements remove all rows from the table titles for which no
publisher exists in the table publishers:

    DELETE FROM titles
    WHERE NOT EXISTS
    (SELECT * FROM publishers
    WHERE publishers.pub_id =
    titles.pub_id);

or

    DELETE FROM titles
    WHERE pub_id NOT IN
    (SELECT pub_id FROM publishers);

TRUNCATE works like a DELETE statement with no WHERE clause: Both remove all
rows in a table. But TRUNCATE is faster and uses fewer system resources than
DELETE because TRUNCATE doesn’t scan the entire table and record changes in the
transaction log.

    TRUNCATE TABLE table;

Creating tables
---------------
[top](#content)

    CREATE TABLE table
    (
    column1 data_type1 [col_constraints1],
    column2 data_type2 [col_constraints2],
    ...
    columnN data_typeN [col_constraintsN]
    [, table_constraint1]
    [, table_constraint2]
    ...
    [, table_constraintM]
    );


### Constraints
[top](#content)

| Constraint  | Description                                                                       |
|-------------|-----------------------------------------------------------------------------------|
| NOT NULL    | Prevents nulls from being inserted into a column                                  |
| PRIMARY KEY | Sets the table’s primary-key column(s)                                            |
| FOREIGN KEY | Sets the table’s foreign-key column(s)                                            |
| UNIQUE      | Prevents duplicate values from being inserted into a column                       |
| CHECK       | Limits the values that can be inserted into a column by using Boolean expressions |

To name a constraint:
    CONSTRAINT constraint_name
constraint_name is the name of the constraint and is a valid SQL identifier.
Constraints names must be unique within a table.

Add the following column constraint to a CREATE TABLE column definition:

    [CONSTRAINT constraint_name]
    NOT NULL

NOT NULL forbids nulls in a column.

DB2 and MySQL don’t accept named NOT NULL constraints. Omit the clause
`CONSTRAINT constraint_name` from `NOT NULL` column definitions.

### Default values

To specify a column’s default value: Add the following clause to a CREATE TABLE
column definition:
    DEFAULT expr

### Primary Key
[top](#content)

- To specify a simple primary key as a column constraint, add the following
column constraint to a CREATE TABLE column definition:

        [CONSTRAINT constraint_name]
        PRIMARY KEY

or to specify a simple primary key as a table constraint, add the following table
constraint to a CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    PRIMARY KEY (key_column)

    CREATE TABLE publishers
    (
    pub_id CHAR(3) NOT NULL,
    pub_name VARCHAR(20) NOT NULL,
    city VARCHAR(15) NOT NULL,
    state CHAR(2) ,
    country VARCHAR(15) NOT NULL,
    CONSTRAINT publishers_pk
    PRIMARY KEY (pub_id)
    );

To specify a composite primary key: Add the following table constraint to a
CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    PRIMARY KEY (key_columns)

    CONSTRAINT title_authors_pk
    PRIMARY KEY (title_id, au_id)

### Foreign Key
[top](#content)


To specify a simple foreign key:
- To specify a simple foreign key as a column constraint, add the following column
constraint to a CREATE TABLE column definition:

        [CONSTRAINT constraint_name]
        REFERENCES ref_table(ref_column)

or to specify a simple foreign key as a table constraint, add the following table
constraint to a CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    FOREIGN KEY (key_column)
    REFERENCES ref_table(ref_column)

To specify a composite foreign key: Add the following table constraint to a
CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    FOREIGN KEY (key_columns)
    REFERENCES ref_table(ref_columns)

SQL lets you define the action the DBMS takes when you try to UPDATE or DELETE
a key value (in a parent table) to which foreign-key values point. To trigger a
referential action, specify an ON UPDATE or ON DELETE clause in the FOREIGN KEY
constraint.

#### ON UPDATE
[top](#content)

- **CASCADE** updates the dependent foreign key values to the new parent-key value.
- **SET NULL** sets the dependent foreign-key values to nulls.
- **SET DEFAULT** sets the dependent foreign key values to their default values.
- **NO ACTION** generates an error on a foreign key violation. This action is the
default.

#### ON DELETE
[top](#content)

- **CASCADE** deletes the rows that contain foreign-key values that match the
deleted parent-key value.
- **SET NULL** sets the dependent foreign-key values to null.
- **SET DEFAULT** sets the dependent foreignkey values to their default values.
- **NO ACTION** generates an error on a foreignkey violation. This action is the
default.

MySQL enforces foreign-key constraints through InnoDB tables.

### UNIQUE
[top](#content)

- A one-column key is a simple constraint; a multiple-column key is a composite
constraint.
- In a composite constraint, values can be duplicated within one column, but
each combination of values from all the columns must be unique.

To specify a simple unique constraint as a column constraint, add the following
column constraint to a CREATE TABLE column definition:

    [CONSTRAINT constraint_name]
    UNIQUE

or to specify a simple unique constraint as a table constraint, add the following
table constraint to a CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    UNIQUE (unique_column)

To specify a composite unique constraint: Add the following table constraint to
a CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    UNIQUE (unique_columns)

### CHECK
[top](#content)

- **Minimum or maximum values**. Prevent sales of fewer than zero items, for example.
- **Specific values.** Allow only ‘biology’, ‘chemistry’, or ‘physics’ in the
column science, for example.
- **A range of values.** Make sure that an author’s royalty rate is between 2 percent
and 20 percent, for example.

To add a check constraint as a column constraint or table constraint, add the
following constraint to a CREATE TABLE definition:

    [CONSTRAINT constraint_name]
    CHECK (condition)

### Temporary Tables
[top](#content)

Temporary tables commonly are used to:
- Store the result of a complex, timeconsuming query once and use the result
repeatedly in subsequent queries, improving performance greatly.
- Create an image, or snapshot, of a table at a particular moment in time.
- Hold intermediate results of long or complex calculations.

A temporary table is a table that the DBMS empties automatically at the end of a
session or transaction. (The table’s data are destroyed along with the table.)
A session is the time during which you’re connected to a DBMS— between login and
logoff—and the DBMS accepts and executes your commands.

To create a temporary table:

    CREATE {LOCAL | GLOBAL} TEMPORARY TABLE table
    (
    column1 data_type1 [constraints1],
    column2 data_type2 [constraints2],
    ...
    columnN data_typeN [constraintsN]
    [, table_constraints]
    );

MySQL doesn’t distinguish between local and global temporary tables; omit the
keyword LOCAL or GLOBAL.

### CREATE TABLE AS
[top](#content)

The CREATE TABLE AS statement creates a new table and populates it with the result
of a SELECT. CREATE TABLE AS commonly is used to:
- Archive specific rows
- Make backup copies of tables
- Create a snapshot of a table at a particular moment in time
- Quickly duplicate a table’s structure but not its data
- Create test data
- Copy a table to test INSERT, UPDATE, and DELETE operations before modifying
production data

- You can choose rows for the new table by using the standard SELECT clauses
WHERE, JOIN, GROUP BY, and HAVING
- CREATE TABLE AS inserts rows into a single table regardless of how many source
tables the SELECT references.
- The properties of the columns and expressions in the SELECT-clause list define
the new table’s structure.

To create a new table from an existing table:

    CREATE TABLE new_table
    AS subquery;

    CREATE TABLE authors2 AS
    SELECT *
    FROM authors;

    CREATE GLOBAL TEMPORARY TABLE titles2 AS
    SELECT title_name, sales
    FROM titles
    WHERE pub_id = 'P01';

Create a new table named author_title_names that contains the names of the authors
who aren’t from New York state or California and the titles of their books.

    CREATE TABLE author_title_names AS
    SELECT a.au_fname, a.au_lname,
    t.title_name
    FROM authors a
    INNER JOIN title_authors ta
    ON a.au_id = ta.au_id
    INNER JOIN titles t
    ON ta.title_id = t.title_id
    WHERE a.state NOT IN ('CA', 'NY');

### ALTER TABLE
[top](#content)

some of the modifications that you can make by using ALTER TABLE are:
- Add or drop a column
- Alter a column’s data type
- Add, alter, or drop a column’s default value or nullability constraint
- Add, alter, or drop column or table constraints such as primary-key, foreign-key,
unique, and check constraints
- Rename a column
- Rename a table

To alter a table:

    ALTER TABLE table
    alter_table_action;

Some example actions are:

    ADD COLUMN column type [constraints]
    ALTER COLUMN column SET DEFAULT expr
    DROP COLUMN column [RESTRICT|CASCADE]
    ADD table_constraint
    DROP CONSTRAINT constraint_name

    ALTER TABLE authors
    ADD email_address CHAR(25);

    ALTER TABLE authors
    DROP COLUMN email_address;

    RENAME TABLE old_name TO new_name;

You can’t drop a table’s only remaining column.

### DROP TABLE
[top](#content)

- Dropping a table destroys its structure, data, indexes, constraints, permissions,
and so on.
- Dropping a table isn’t the same as deleting all its rows. You can empty a table
of rows, but not destroy it, with DELETE FROM table

To drop a table:

    DROP TABLE table;

Standard SQL lets you specify RESTRICT or CASCADE drop behavior.

- RESTRICT (which is safe) prevents you from dropping a table that’s referenced
by views or other constraints.
- CASCADE (which is dangerous) causes referencing objects to be dropped along
with the table.

Indexes
=======
[top](#content)

In general, indexes are appropriate for columns that are frequently:
- Searched (WHERE)
- Sorted (ORDER BY)
- Grouped (GROUP BY)
- Used in joins (JOIN)
- Used to calculate order statistics (MIN(), MAX(), or the median, for example)

In general, indexes are inappropriate for columns that:
- Accept only a few distinct values (gender, marital_status, or state, for example)
- Are used rarely in queries
- Are part of a small table with few rows

- An index can reference one or more columns in a table. An index that references
a single column is a simple index; an index that references multiple columns is
a composite index. Columns in a composite index need not be adjacent in the table.
A single index can’t span multiple tables.

To create an index:

    CREATE [UNIQUE] INDEX index
    ON table (index_columns);

A foreign key and is a good candidate for an index because:
- Changes to PRIMARY KEY constraints are checked with FOREIGN KEY constraints in
related tables.
- Foreign-key columns often are used in join criteria when the data from related
tables are combined in queries by matching the FOREIGN KEY column(s) of one
table with the PRIMARY KEY or UNIQUE column(s) in the other table.

Create a composite index on the columns state and city for the table authors.

    CREATE INDEX state_city_idx
    ON authors (state, city);

The DBMS uses this index when you sort rows in state plus city order. This index
is useless for sorts and searches on state alone, city alone, or city plus state;
you must create separate indexes for those purposes.

- Don’t use the terms index and key interchangeably. An index is a physical
(hardware-related) mechanism that the DBMS uses to improve performance.
A key is a logical (based on data) concept that the DBMS uses to enforce
referential integrity and update through views.

- Indexes are files stored on disk and so occupy storage space (possibly a lot of
space). But when used properly, indexes are the primary means of reducing disk
wear and tear by obviating the need to read large tables sequentially. While a
DBMS is creating an index, it uses as much as 1.5 times the space that the
associated table occupies (make sure you have room). Most of that space is
released after the index is complete.

To drop an index in MySQL:

    DROP INDEX index
    ON table;

    DROP INDEX pub_id_idx
    ON titles;

Views
=====
[top](#content)

To create a view:

    CREATE VIEW view [(view_columns)]
    AS select_statement;

Create a view that lists the last names of authors A02 and A05, and the books
that each one wrote (or cowrote).

    CREATE VIEW au_titles (LastName, Title)
    AS
    SELECT an.au_lname, t.title_name
    FROM title_authors ta
    INNER JOIN au_names an
    ON ta.au_id = an.au_id
    INNER JOIN titles t
    ON t.title_id = ta.title_id
    WHERE an.au_id in ('A02','A05');

In Microsoft SQL Server, Oracle, DB2, MySQL, and PostgreSQL, you can add the
optional clause **WITH [CASCADED | LOCAL]** CHECK OPTION when you create a view.
This clause applies to only updateable views and ensures that only data that can
be read by the view can be inserted, updated, or deleted.

To see data through a view, query the view by using SELECT, just as you would
query a table.

To retrieve data through a view:

    SELECT columns
    FROM view
    [JOIN joins]
    [WHERE search_condition]
    [GROUP BY group_columns]
    [HAVING search_condition]
    [ORDER BY sort_columns];

Each row in an updateable view is associated with exactly one row in an underlying
base table. A view isn’t updateable if its SELECT statement uses GROUP BY, HAVING,
DISTINCT, or aggregate functions, for example.

To drop a view:

    DROP VIEW view;

- Dropping a table doesn’t drop the views that reference that table, so you must
drop the views with DROP VIEW explicitly.

Transactions
============
[top](#content)

**Commit.**

Committing a transaction makes all data modifications performed since the start
of the transaction a permanent part of the database. After a transaction is
committed, all changes made by the transaction become visible to other users and
are guaranteed to be permanent if a crash or other failure occurs.

**Roll back.**

Rolling back a transaction retracts any of the changes resulting from the SQL
statements in the transaction.  After a transaction is rolled back, the affected
data are left unchanged, as though the SQL statements in the transaction were
never executed.

**Transaction log.**

The transaction log file, or just log, is a serial record of all modifications
that have occurred in a database via transactions. The transaction log records
the start of each transaction, the changes to the data, and enough information
to undo or redo the changes made by the transaction (if necessary later). The log
grows continually as transactions occur in the database.

To start a transaction explicitly:
- In MySQL or PostgreSQL, type:

        START TRANSACTION;

- To commit a transaction:

        COMMIT;

- To roll back a transaction:

        ROLLBACK;

ACID
----

ACID is an acronym that summarizes the properties of a transaction:

**Atomicity.** Either all of a transaction’s data modifications are performed,
or none of them are.

**Consistency.** A completed transaction leaves all data in a consistent state
that maintains all data integrity. A consistent state satisfies all defined
database constraints. (Note that consistency isn’t necessarily preserved at any
intermediate point within a transaction.)

**Isolation.** A transaction’s effects are isolated (or concealed) from those of
all other transactions.

**Durability.** After a transaction completes, its effects are permanent and
persist even if the system fails.

For long transactions, you can set arbitrary intermediate markers, called
savepoints, to divide a transaction into smaller parts.

    SAVEPOINT savepoint_name;

Tricks
======
[top](#content)

Calculating Running Statistics
------------------------------

    SELECT
    t1.title_id,
    SUM(t2.sales) AS RunSum,
    AVG(t2.sales) AS RunAvg,
    COUNT(t2.sales) AS RunCount
    FROM titles t1, titles t2
    WHERE t1.title_id >= t2.title_id
    GROUP BY t1.title_id
    ORDER BY t1.title_id;

Generating Sequences
--------------------
[top](#content)

To define a sequence generator:

    CREATE SEQUENCE seq_name
    [INCREMENT [BY] increment]
    [MINVALUE min | NO MINVALUE]
    [MAXVALUE max | NO MAXVALUE]
    [START [WITH] start]
    [[NO] CYCLE];

    CREATE SEQUENCE part_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 10000
    START WITH 1
    NO CYCLE;

    INSERT INTO shipment(
    part_num,
    desc,
    quantity)
    VALUES(
    NEXT VALUE FOR part_seq,
    ‘motherboard’,
    5);

If you’re creating a column of unique values, you can use the keyword IDENTITY
to define a sequence right in the CREATE TABLE statement:

    CREATE TABLE parts (
    part_num INTEGER AS
    IDENTITY(INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 10000
    START WITH 1
    NO CYCLE),
    desc AS VARCHAR(100),
    quantity INTEGER;

This table definition lets you omit NEXT VALUE FOR when you insert a row:

    INSERT INTO shipment(
    desc,
    quantity)
    VALUES(
    ‘motherboard’,
    5);

SQL also provides ALTER SEQUENCE and DROP SEQUENCE to change and remove
sequence generators.

LIMIT
-----
[top](#content)

List the top three salespeople, without ties(if two rows have the same value,
only one will be displayed):

    SELECT emp_id, sales
    FROM empsales
    ORDER BY sales DESC
    LIMIT 3;

List the top three salespeople, with ties.

    SELECT emp_id, sales
    FROM empsales
    WHERE sales >= COALESCE(
    (SELECT sales
    FROM empsales
    ORDER BY sales DESC
    LIMIT 1 OFFSET 2),
    (SELECT MIN(sales)
    FROM empsales))
    ORDER BY sales DESC;

List the top three salespeople, skipping the initial four rows.

    SELECT emp_id, sales
    FROM empsales
    ORDER BY sales DESC
    LIMIT 3 OFFSET 4;

The LIMIT clause’s syntax is:

    LIMIT n [OFFSET skip]

or

    LIMIT [skip,] n

The offset of the initial row is 0 (not 1).

Calculating a Trimmed Mean
--------------------------
[top](#content)

Calculate the trimmed mean for k = 3 (AVG without the highest 3 and the lowest 3).

    SELECT AVG(sales) AS TrimmedMean
    FROM titles t1
    WHERE
    (SELECT COUNT(*)
    FROM titles t2
    WHERE t2.sales <= t1.sales) > 3
    AND
    (SELECT COUNT(*)
    FROM titles t3
    WHERE t3.sales >= t1.sales) > 3;

Picking Random Rows
-------------------
[top](#content)

Select about 25% percent of the rows in the table titles at random.

    SELECT title_id, type, sales
    FROM titles
    WHERE RAND() < 0.25;

Selecting Every nth Row
-----------------------

The condition `MOD(rownumber,n) = 0` picks every nth row, where rownumber is a
column of consecutive integers or row identifiers.

Metadata
--------
[top](#content)

Metadata statements and commands for MySQL:

    -- List the databases (Method 1).
    SELECT schema_name
    FROM information_schema.schemata;
    -- List the databases (Method 2, in mysql).
    SHOW DATABASES;
    -- List the tables (Method 1).
    SELECT table_name
    FROM information_schema.tables
    WHERE table_schema = 'db_name';
    -- List the tables (Method 2, in mysql).
    SHOW TABLES;
    -- Describe a table (Method 1).
    SELECT *
    FROM information_schema.columns
    WHERE table_schema = 'db_name'
    AND table_name = 'table_name';
    -- Describe a table (Method 2, in mysql).
    DESCRIBE table_name

Working with Dates
------------------
[top](#content)

The function `date_format()` formats a datetime according to the specified format.
`current_timestamp` returns the current (system) date and time. The standard
addition and subtraction operators add and subtract time intervals from a date.
`datediff()` returns the number of days between two dates.

Alternatives to `date_format()` are the extraction functions `extract(),` `second(),`
`day(),` `month(),` and so on.

    -- Extract parts of the current datetime.
    SELECT
    date_format(current_timestamp,'%s')
    AS sec_pt,
    date_format(current_timestamp,'%i')
    AS min_pt,
    date_format(current_timestamp,'%k')
    AS hr_pt,
    date_format(current_timestamp,'%d')
    AS day_pt,
    date_format(current_timestamp,'%m')
    AS mon_pt,
    date_format(current_timestamp,'%Y')
    AS yr_pt;
    -- Add or subtract days, months, and years.
    SELECT
    pubdate + INTERVAL 2 DAY AS p2d,
    pubdate - INTERVAL 2 DAY AS m2d,
    pubdate + INTERVAL 2 MONTH AS p2m,
    pubdate - INTERVAL 2 MONTH AS m2m,
    pubdate + INTERVAL 2 YEAR AS p2y,
    pubdate - INTERVAL 2 YEAR AS m2y
    FROM titles
    WHERE title_id = 'T05';
    -- Count the days between two dates.
    SELECT datediff(date2,date1) AS days
    FROM
    (SELECT pubdate as date1
    FROM titles
    WHERE title_id = 'T05') t1,
    (SELECT pubdate as date2
    FROM titles
    WHERE title_id = 'T06') t2;
    -- Count the months between two dates.
    SELECT
    (year(date2)*12 + month(date2)) -
    (year(date1)*12 + month(date1))
    AS months
    FROM
    (SELECT
    MIN(pubdate) AS date1,
    MAX(pubdate) AS date2
    FROM titles) t1;
