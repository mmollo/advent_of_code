const fs = require('fs')
const re = /([\d]+) +(\d+) +(\d+)/
input = fs.readFileSync('input').toString().trim().split("\n")

let count = 0;
input.forEach(line => {

    [_dummy, a, b, c, ...rest] = re.exec(line);    
    [a,b,c] = [a,b,c].map(x => { return parseInt(x); }).sort((a,b) => a > b)
    
    if(a + b > c) {
        count++;
    }
})

console.log(count)