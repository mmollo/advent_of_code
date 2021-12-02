defmodule A do
  import String

  def solve(input), do: solve(input, {0, 0})

  defp solve([head | tail], {x, y}) do
    [direction, value] = split(head)
    value = to_integer(value)

    x =
      case direction do
        "forward" -> x + value
        _ -> x
      end

    y =
      case direction do
        "up" -> y - value
        "down" -> y + value
        _ -> y
      end

    solve(tail, {x, y})
  end

  defp solve([], {x, y}), do: x * y
end

defmodule B do
  import String

  def solve(input), do: solve(input, {0, 0, 0})

  defp solve([head | tail], {x, y, a}) do
    [direction, value] = split(head)
    value = to_integer(value)

    a =
      case direction do
        "up" -> a - value
        "down" -> a + value
        _ -> a
      end

    x =
      case direction do
        "forward" -> x + value
        _ -> x
      end

    y =
      case direction do
        "forward" -> y + value * a
        _ -> y
      end

    solve(tail, {x, y, a})
  end

  defp solve([], {x, y, _a}), do: x * y
end

input =
  File.read!("./input")
  |> String.split("\n", trim: true)

input
|> A.solve()
|> IO.puts()

input
|> B.solve()
|> IO.puts()
