; 1
(define (diff l1 l2)
  (filter (lambda (x) (not (member x l2))) l1))

; 2
; if l2 starts with l1
(define (prefix? l1 l2)
  (cond ((null? l1) #t)
        ((null? l2) #f)
        ((not(= (car l1) (car l2))) #f)
        (else (prefix? (cdr l1) (cdr l2)))))

; 3
(define (subseq l1 l2)
  (cond ((null? l2) #f)
        ((equal? l1 l2) #t)
        ((= (length l1) (length l2)) #f)
        ((prefix? l1 l2) #t)
        (else (subseq l1 (cdr l2)))))

; 4
; how many times each element is in list1
(define (count-single-digit digit list1)
   (apply + (map (lambda (x) (if (= digit x) 1 0))list1)))

(define (count-each l1 l2)
  (append (map (lambda (x) (cons x (count-single-digit x l2))) l1)))

; 5
; for each unique key return average: ((1.2) (1.5)) => ((1.3,5))
(define (av number list1)
  (append (map (lambda (x) (if (= (car x) number) (cdr x) `()))list1)))

; 6
; return a value by key
(define (makef list1)
  (lambda (x)
    (cond ((null? list1) "The list is empty" )
      ((and (= (length list1) 1) (not (= (caar list1) x))) "There is no such key")
          ((= (caar list1) x) (cdar list1))
          (else ((makef (cdr list1)) x)))))
