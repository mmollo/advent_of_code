require 'set'
input = File.read('sample').split("\n")

# Valve OS has flow rate=0; tunnels lead to valves EE, CL
input = input.map do |l|

    valve, rate, tunnels = l.match(/([A-Z]{2}).+=(\d+).+ valves? ([A-Z, ]+)/s).captures
    rate = rate.to_i
    tunnels = tunnels.split(', ')
    
    [valve, rate, tunnels]
end



class Network
    def initialize
        @valves = {}
    end
    
    def valve(name)
        @valves[name] ||= Valve.new(name)
    end
    
    def valves = @valves.values
end

class Valve
    attr_reader :name, :rate
    attr_accessor :rate, :tunnels
    def initialize(name)
        @name = name
        @rate = 0
        @tunnels = Set.new
    end
    
    def join(valve)
        @tunnels << valve
        valve.tunnels << self
    end
end

def build(input)    
    network = Network.new
    input.each do |name, rate, tunnels|
        v1 = network.valve(name)
        v1.rate = rate
        tunnels.each do |name|
          v2 = network.valve(name)
          v2.join(v1)
        end
    end
    network
end


class Route
    def initialize
        @valves = Set.new
    end
    
    def add(valve)
        @valves << valve
    end
    
    def flow
        
    end
end

network = build(input)
network.valves.each do |v1|
    #p "#{v1.name}"
    v1.tunnels.each do |v2|
     #   p "- #{v2.name}"
    end
end

def routes(from, path = [], out = [])
    from.tunnels.each do |v2|
        next if path.include? v2
        out << [from.name, v2.name]
        routes(v2, path + [v2])
    end
    
    out
end

start =  routes network.valves.first
ii = network.valve('II')

p routes(ii, [network.valves.first])
