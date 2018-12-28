Code.require_file("common.exs")

input = Day7.create_input("input")

override =
  input
  |> Day7.resolve("a")
  |> elem(0)

input
|> Map.put("b", override)
|> Day7.resolve("a")
|> elem(0)
|> IO.inspect()
