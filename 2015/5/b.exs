defmodule A do
  def resolve(input) do
    input
    |> Stream.filter(&has_pairs(&1))
    |> Stream.filter(&no_overlaps(&1))
    |> Stream.filter(&mirror_letter(&1))
  end

  def no_overlaps(<<first, second, rest::binary>>) do
    no_overlaps(rest, first, second)
  end

  defp no_overlaps(<<third, rest::binary>>, first, second) do
    case third == second && second == first do
      true -> false
      false -> no_overlaps(rest, second, third)
    end
  end

  defp no_overlaps(<<>>, _, _) do
    true
  end

  def has_pairs(str) do
    str
    |> get_pairs
    |> Enum.group_by(& &1)
    |> Enum.filter(fn {_pair, list} -> Enum.count(list) > 1 end)
    |> Enum.count() > 0
  end

  defp get_pairs(<<first, rest::binary>>) do
    get_pairs(rest, first)
  end

  defp get_pairs(<<first, rest::binary>>, letter) do
    get_pairs(rest, first, [<<first>> <> <<letter>>])
  end

  def get_pairs(<<first, rest::binary>>, letter, acc) when is_list(acc) do
    get_pairs(rest, first, [<<first>> <> <<letter>> | acc])
  end

  def get_pairs(<<>>, _, acc) do
    acc
  end

  def mirror_letter(<<letter, mirror, rest::binary>>) do
    mirror_letter(rest, letter, mirror)
  end

  defp mirror_letter(<<letter, rest::binary>>, letter2, mirror) do
    case letter2 == letter do
      true -> true
      false -> mirror_letter(rest, mirror, letter)
    end
  end

  defp mirror_letter(<<>>, _, _) do
    false
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
