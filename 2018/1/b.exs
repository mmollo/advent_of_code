input = File.read!('input')
|> String.split(["\r", "\n"], trim: true)
|> Enum.map(fn v -> String.to_integer v end)

defmodule B do
    def main([var|tail], freq, past) do
        nfreq = freq + var
        # IO.puts "#{freq} + #{var} =  #{nfreq}"
        if MapSet.member?(past, nfreq) do
            nfreq
        else
            npast = MapSet.put(past, nfreq)
            main(tail ++ [var], nfreq, npast)            
        end
    end
end

IO.puts B.main(input, 0, MapSet.new([]))

