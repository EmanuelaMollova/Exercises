def partition(number)
  0.upto(number / 2).zip number.downto(number / 2)
end
