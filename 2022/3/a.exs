defmodule Day3 do
  def input do
    File.read!('sample') |> String.trim() |> String.split("\n")
  end

  def priority(<<c>>) do
    if c >= 96 do
      c - 96
    else
      c - 38
    end
  end

  def a do
    input()
    |> Enum.map(fn l ->
      [a, b] = half(l)

      a = String.split(a, "", trim: true) |> Enum.uniq()
      b = String.split(b, "", trim: true) |> Enum.uniq()

      intersect(a, b) |> List.first() |> priority
    end)
    |> Enum.sum()
  end

  def b do
    input()
    |> Enum.chunk_every(3)
    |> Enum.map(fn [l1, l2, l3] ->
        String.split(l1, "", trim: true) |> intersect(String.split(l2, "", trim: true)) |> intersect(String.split(l3, "", trim: true))
    end)
  end

  defp half(str) do
    len = String.length(str) |> div(2)
    [String.slice(str, 0..(len - 1)), String.slice(str, len..-1)]
  end

  defp intersect(a, b) do
    Enum.filter(a, fn x -> Enum.member?(b, x) end)
  end
end

# def b(input) do
# input.each_slice(3).map do |l|
# priority((l[0].chars & l[1].chars & l[2].chars).first)
# end.sum
# end

IO.puts(Day3.a())
IO.inspect(Day3.b())
