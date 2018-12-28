function read(input) {
    acc = 0
    if(Array.isArray(input)) {
        input.forEach(e => {
            acc += read(e)
        })
        return acc
    }

    switch(typeof input) {
        case "object":
            if(-1 !== Object.keys(input).map(k => input[k]).indexOf("red")) {
                return 0
            }
            Object.keys(input).forEach(e => {
                acc += read(input[e], acc)
            })
            return acc;
        case "string": return 0
        case "number": return(parseInt(input))
    }
}

console.log(read(JSON.parse(require('fs').readFileSync('input'))))
