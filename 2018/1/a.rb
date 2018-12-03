puts open('input')
.read
.split("\n")
.map{|x| x.to_i}
.reduce(:+)
    
