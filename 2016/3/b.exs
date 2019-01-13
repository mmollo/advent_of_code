defmodule A do
  def create_input(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_line/1)
  end

  def resolve(input) when is_list(input) do
    resolve(input, {[], [], []}, [])
  end

  def resolve([[a, b, c] | tail], {ta, tb, tc}, acc) do
    {ta, tb, tc, acc} =
      case Enum.count(ta) == 2 do
        false -> {[a | ta], [b | tb], [c | tc], acc}
        true -> {[], [], [], acc ++ [[a | ta], [b | tb], [c | tc]]}
      end

    resolve(tail, {ta, tb, tc}, acc)
  end

  def resolve([], _, acc) do
    acc
    |> Enum.filter(&is_triangle/1)
    |> Enum.count()
  end

  defp is_triangle(triangle) when is_list(triangle) do
    [a, b, c] = Enum.sort(triangle)
    a + b > c
  end

  defp parse_line(line) do
    Regex.run(~r/([\d]+) +([\d]+) +([\d]+)/, line, capture: :all_but_first)
    |> Enum.map(&String.to_integer/1)
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
