-- maxDuplicate
-- argument: list of lists
-- returns: the biggest number, which is duplicated in its own list

-- helper
isUnique number [] = True
isUnique number (x:xs)
    | number == x && elem x xs = False
    | otherwise = isUnique number xs

-- helper
remDup [] = []
remDup (x:xs)
    | elem x xs = remDup xs
    | otherwise = x : remDup xs

-- helper
duplicates list = remDup[ x | x <- list, (isUnique x list) == False ]

maxDuplicate list = maximum [ duplicates x | x <- list ]
