-- A product is represented by ordered couple (name, price)
-- The stock in a store is a list of products

-- 1 - closestToAverage - returns the product with price closest to the average price of all products
store1 = [ ("bread", 1), ("milk", 2.5), ("lamb", 10), ("cheese", 5), ("butter", 2.3) ]

-- Find average price
findAverage store = sum prices/fromIntegral (length prices )
  where prices = [ price | (name, price) <- store ]

closestToAverage store = head [ name | (name, price) <- store, abs (price - findAverage store) == mindiff ]
  where mindiff = minimum [ abs (price - findAverage store) | (_, price) <- store ]

-- 2 - cheaperAlternative - finds the number of products for each there is a product with the same name, but cheaper price
store2 = [ ("bread", 1), ("cheese", 2.5), ("bread", 1), ("cheese", 5), ("butter", 2.3) ]

-- List of all the prices for a product
allPricesOfKind product store = [ price | (name, price) <- store, name == product ]

-- Are all elements of a list the same
areAllTheSame [x] = True
areAllTheSame (x:xs)
    | head xs == x = areAllTheSame xs
    | head xs /= x = False

getName (name, _) = name

-- If there is a cheaper version, returns its name, otherwise returns []
findCheaper pr store
    | areAllTheSame (allPricesOfKind pr store) = []
    | otherwise = [pr]

remDup [] = []
remDup (x:xs)
    | elem x xs = remDup xs
    | otherwise = x : remDup xs

cheaperAlternative store = length (remDup (foldl1 (++)[ findCheaper pr store | (pr, price) <- store  ]))
