-- 1 - Common digits in two numbers
commonDigits number1 number2 =
    length (remDup(intersection (intToList number1) (intToList number2)))
      where
        intToList number1
            | number1 < 10 = [number1]
            | otherwise = mod number1 10 : intToList (quot number1 10)

-- 2 - Is a number with increasing digits
isIncreasing number
    | number < 10 = True
    | (number < 100) && (number `mod` 10 > number `quot` 10) = True
    | number `mod` 10 > (number `quot` 10) `mod` 10 = isIncreasing (number `quot` 10)
    | otherwise = False

-- 3 - superOr with accumulate
accum a b nv comb op next
    | a > b = nv
    | otherwise = comb (op a) (accum (next a) b nv comb op next)

superOr a b f =
    accum a b False (||) f succ

-- 4 - Merge for sorted lists
merge list [] = list
merge [] list = list
merge (x:xs) (y:ys)
    | x <= y = x : merge xs (y:ys)
    | otherwise = y : merge (x:xs) ys

-- 5 - Union
union list1 list2 = list1 ++ list2

-- 6 - Intersection
intersection list1 list2 = [ x | x <- list1, elem x list2 ]

-- 7 - Difference
diff list1 list2 = [ x | x <- list1, not(elem x list2) ]

-- 8 - Remove duplicates
remDup [] = []
remDup (x:xs) =
    if elem x xs then remDup xs
    else x:remDup xs
