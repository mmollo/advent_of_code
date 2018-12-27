defmodule A do
  def resolve(input) do
    input
    |> Stream.filter(&has_vowels(&1, 3))
    |> Stream.filter(&twice_in_a_row(&1))
    |> Stream.filter(&no_bad_strings(&1))
  end

  def has_vowels(str, amount \\ 3) do
    str
    |> String.graphemes()
    |> Enum.count(fn x -> x in ["a", "e", "i", "o", "u"] end) >= amount
  end

  def twice_in_a_row(<<letter1, rest::binary>>) do
    twice_in_a_row(rest, letter1)
  end

  defp twice_in_a_row(<<letter1, rest::binary>>, letter2) do
    case letter1 == letter2 do
      true -> true
      false -> twice_in_a_row(rest, letter1)
    end
  end

  defp twice_in_a_row(<<>>, _) do
    false
  end

  def no_bad_strings(str) do
    !String.contains?(str, ["ab", "cd", "pq", "xy"])
  end

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
  end
end

A.create_input("input")
|> A.resolve()
|> Enum.count()
|> IO.inspect()
