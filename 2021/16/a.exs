# input = String.trim(File.read!('./input'));
#input = "D2FE28"
input = "38006F45291200"

input =
  input
  |> to_charlist
  |> Enum.chunk_every(2)
  |> Enum.into(<<>>, fn x -> <<List.to_integer(x, 16)>> end)

defmodule A do
  def parse(<<version::3, type::3, rest::bits>>) when type == 4 do
    # Litteral value
    [value, rest] = parse_litteral(rest)

    [version, type, value, rest]
  end

  def parse(<<version::3, type::3, id::1, rest::bits>>) when type != 4 do
    # Operator
    [version, type, parse_operator(id, rest)]
  end

  defp parse_operator(0, <<length::15, rest::bits>>) do
    IO.puts("Operator with subpackets of length #{length}")
    [version, type, z, qq] = parse(rest)
  end

  defp parse_operator(1, <<number::11, rest::bits>>) do
    IO.puts("Operator with #{number} subpackets")

    parse(rest)
  end

  defp parse_litteral(<<prefix::1, value::4, rest::bits>>, acc \\ 0)do
    case prefix do
		0 -> [acc * 16 + value, rest]
		1 -> parse_litteral(rest, acc * 16 + value)
	end
  end

end

A.parse(input)
|> IO.inspect()
