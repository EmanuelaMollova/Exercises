-- movesOutside
-- arguments: matrix of numbers, function f with one argument
-- returns: list of all colums of the matrix, which are moved by f
-- a column is moved by f if for each x from c, f(x) is not an element of c
-- (c is a column)

-- Find the n-th column of a matrix
findColumn n list = [ x!!n | x <- list ]

-- Find all columns of a matrix
findAllColumns list = map (\ x -> findColumn x list) [0..((length (head list)) - 1)]

-- Helper for isMoved
isMovedOneSide f [] = True
isMovedOneSide f (x:xs)
    | elem (f x) xs = False
    | otherwise = isMoved f xs

-- Is a column moved
isMoved f list = isMovedOneSide f list && isMovedOneSide f (reverse list)

movesOutside list f = [ x | x <- (findAllColumns list), isMoved  f x]
