const { readFileSync } = require('fs')

const input = readFileSync('./input').toString().trim().split("\r\n")

function a(input) {
	let map = {}
	const reg = /([0-9]+)/g
	for(let line of input) {
		let [a,b,c,d] = [...line.match(reg)].map(x => parseInt(x))
		if(a != c && b != d) continue
		for(let i = Math.min(a,c) ; i <= Math.max(a,c) ; i++) {
			for(let j = Math.min(b,d) ; j <= Math.max(b,d) ; j++) {
				map[i + ':' + j] ??= 0
				map[i + ':' + j]++
			}
		}
	}
	return Object.values(map).filter(x => x > 1).length
}

function b(input) {
	return 0
}

console.log(a(input))
console.log(b(input))
