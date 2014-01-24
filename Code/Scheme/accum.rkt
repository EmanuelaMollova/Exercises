(define (p1 x) (+ x 1))

(define (accum a b nv comb op next)
  (if (> a b)
      nv
      (comb (op a) (accum (next a) b nv comb op next))))

(define (super-or a b f)
  (accum a b #f   (lambda (x y) (if(or x y) #t #f)) f p1))

(define (del-9? a)
  (if (= (remainder a 9) 0) #t
      #f))

