-- 1
sumMax list = sum [ maximum x | x <- list ]

-- 2
countElem elem list = length [ x | x <- list, x == elem ]

remDup [] = []
remDup (x:xs) =
    if elem x xs then remDup xs
    else x:remDup xs

mostFrequent list =  remDup [ x | x <- list, countElem x list == mostfr ]
    where mostfr = maximum [ countElem x list | x <- list]

-- 3
type Order = (String, Int)

db1 = [("Mouse", 3), ("Keyboard", 3), ("Monitor", 2), ("Monitor", 4), ("Mouse", 1)]

getProduct (pr, _) = pr

uniqueProducts db = remDup(map (\a -> getProduct a) db)

getQuantity prod db = sum [ qu | (pr, qu) <- db, pr == prod ]

mostPopular db = remDup[ pr | (pr, qu) <- db, getQuantity pr db == max ]
    where max = maximum (map (\a -> getQuantity a db) (uniqueProducts db))

-- 4
testTree = [ [10, 8, 11], [8, 5, 2], [11, 15, 7] ]

findBiggerChildren list
    | head list < list!!1 && head list < list!!2 = tail list
    | head list < list!!1 = [list!!1]
    | head list < list!!2 = [list!!2]
    | otherwise = []

biggerThanParent list = foldl1 (++)[ findBiggerChildren x | x <- list ]
