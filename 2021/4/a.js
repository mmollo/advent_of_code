const { readFileSync } = require('fs')



input = readFileSync('./input.txt').toString('ascii').split("\n\n")
seq = input.shift().split(',').map(x => parseInt(x))

Cell = function(value, row, col, marked = false) {
	this.value = value
	this.row = row
	this.col = col
	this.marked = marked
}

Board = function (data, size = 5) {
	this.cells = new Map()
	this.rows = new Map()
	this.cols = new Map()
	
	let i = 0;
	data.forEach(n => {
		row = Math.floor(i/size)
		col = i % size
		cell = new Cell(n, row, col)
		this.cells.set(n, cell)
		if(!this.rows.has(row)) {
			this.rows.set(row, [])
		}
		
		if(!this.cols.has(col)) {
			this.cols.set(col, [])
		}
		this.rows.get(row).push(cell)
		this.cols.get(col).push(cell)
		i++;
	})
	
	
}

Board.prototype.mark = function(n) {
	let cell = this.cells.get(n)
	if(cell === undefined) return
	cell.marked = true
	return cell
}

Board.prototype.score = function() {
	s = 0
	this.cells.forEach(c => {
		if(c.marked) return
		s+= c.value
	})
	return s
}

// Part 1
function a(input) {
	boards = new Set(input.map( b => {
console.log(b)
		let data = b.replace(/\n/g, ' ').replace(/ +/g, ' ').trim().split(' ').map(x => parseInt(x))
		console.log(data)
		return new Board(data)
	}))
	let n, b
	seq:
	for(n of seq) {
		boards:
		for(b of Array.from(boards.values())) {
			let cell = b.mark(n)
			if(cell === undefined) continue
			
			if(b.rows.get(cell.row).every(c => c.marked) || b.cols.get(cell.col).every(c => c.marked)) break seq
		}
	}
	console.log(b.cells)
	return n * b.score()
}


// Part 2
function b(input) {
	boards = new Set(input.map( b => {
		let data = b.replace(/\n/g, ' ').replace(/ +/g, ' ').trim().split(' ').map(x => parseInt(x))
		return new Board(data)
	}))
	let n, b
	seq:
	for(n of seq) {
		boards:
		for(b of Array.from(boards.values())) {
			let cell = b.mark(n)
			if(cell === undefined) continue
			
			if(b.rows.get(cell.row).every(c => c.marked) || b.cols.get(cell.col).every(c => c.marked)) {
				if(boards.size === 1) {
					break seq
				}
				boards.delete(b)
			}
		}
	}
	
	b = Array.from(boards.values()).pop()

	return n * b.score()
	
}

console.log(a(input))
console.log(b(input))
