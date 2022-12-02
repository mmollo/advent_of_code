defmodule Input do
  import File, only: [read!: 1]
  import String, only: [trim: 1, split: 2]
  def input(file \\ "input"), do: read!(file) |> trim |> split("\n")
end

defmodule Score do
  def rock(), do: 1
  def paper(), do: 2
  def scissors(), do: 3

  def loss(), do: 0
  def draw(), do: 3
  def win(), do: 6
end

defmodule A do
  import Enum, only: [reduce: 3]
  import List, only: [last: 1]
  import Input
  import Score

  def run do
    input() |> reduce([0, 0], &reducer/2) |> last
  end

  def hand("A X"), do: [rock() + draw(), rock() + draw()]
  def hand("A Y"), do: [rock() + loss(), paper() + win()]
  def hand("A Z"), do: [rock() + win(), scissors() + loss()]
  def hand("B X"), do: [paper() + win(), rock() + loss()]
  def hand("B Y"), do: [paper() + draw(), paper() + draw()]
  def hand("B Z"), do: [paper() + loss(), scissors() + win()]
  def hand("C X"), do: [scissors() + loss(), rock() + win()]
  def hand("C Y"), do: [scissors() + win(), paper() + loss()]
  def hand("C Z"), do: [scissors() + draw(), scissors() + draw()]

  defp reducer(x, [p1, p2]) do
    [s1, s2] = hand(x)
    [p1 + s1, p2 + s2]
  end
end

defmodule B do
  import Enum, only: [reduce: 3]
  import List, only: [last: 1]
  import Input
  import Score

  def run do
    input() |> reduce([0, 0], &reducer/2) |> last
  end

  def hand("A X"), do: [rock() + win(), scissors() + loss()]
  def hand("A Y"), do: [rock() + draw(), rock() + draw()]
  def hand("A Z"), do: [rock() + win(), paper() + win()]
  def hand("B X"), do: [paper() + win(), rock() + loss()]
  def hand("B Y"), do: [paper() + draw(), paper() + draw()]
  def hand("B Z"), do: [paper() + loss(), scissors() + win()]
  def hand("C X"), do: [scissors() + win(), paper() + loss()]
  def hand("C Y"), do: [scissors() + draw(), scissors() + draw()]
  def hand("C Z"), do: [scissors() + loss(), rock() + win()]

  defp reducer(x, [p1, p2]) do
    [s1, s2] = hand(x)
    [p1 + s1, p2 + s2]
  end
end

IO.inspect(A.run())
IO.inspect(B.run())
