import Enum
import String

input =
  File.read!("input")
  |> String.split("\n\n")
  |> map(&split/1)
  |> map(fn elve -> map(elve, &to_integer/1) |> sum end)

IO.puts(max(input))
IO.puts(sort(input, :desc) |> take(3) |> sum)
