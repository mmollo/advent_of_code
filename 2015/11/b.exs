defmodule A do
  def update(password) when is_binary(password) do
    password
    |> String.reverse()
    |> String.graphemes()
    |> update
    |> Enum.join("")
    |> String.reverse()
  end

  def update(password, pos \\ 0) when is_list(password) do
    <<letter>> = Enum.at(password, pos)
    letter = if letter == ?z, do: ?a, else: letter + 1
    password = List.replace_at(password, pos, <<letter>>)

    case letter == ?a do
      false -> password
      true -> update(password, pos + 1)
    end
  end

  def valid?(password) do
    increasing_letters?(password) && !bad_letters?(password) &&
      two_non_overlapping_pairs?(password)
  end

  def increasing_letters?(<<first, second, rest::binary>>) do
    increasing_letters?(rest, first, second)
  end

  def increasing_letters?(<<third, rest::binary>>, first, second) do
    case first + 1 == second && second + 1 == third do
      true -> true
      false -> increasing_letters?(rest, second, third)
    end
  end

  def increasing_letters?(<<>>, _, _), do: false

  def bad_letters?(password) do
    MapSet.intersection(
      MapSet.new(to_charlist(password)),
      MapSet.new('iol')
    )
    |> Enum.count() > 0
  end

  def two_non_overlapping_pairs?(password) when is_binary(password) do
    [
      password |> String.split("", trim: true),
      password |> String.split("", trim: true) |> Enum.drop(1)
    ]
    |> List.zip()
    |> Enum.reduce({[], nil}, fn {a, b}, {selected, last} ->
      cond do
        a == b and b != last -> {[b | selected], b}
        a == b -> {selected -- [b], b}
        true -> {selected, nil}
      end
    end)
    |> elem(0)
    |> Enum.uniq()
    |> Enum.count() > 1
  end

  def next(password) do
    next_password = update(password)

    case valid?(next_password) do
      true -> next_password
      false -> next(next_password)
    end
  end
end

"hxbxwxba"
|> A.next()
|> A.next()
|> IO.inspect()
