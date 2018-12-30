defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_ingredient/1)
  end

  def resolve(ingredients) do
    for a <- 1..97,
        b <- 1..97,
        c <- 1..97,
        d <- 1..97,
        a + b + c + d == 100,
        calories([a, b, c, d], ingredients) == 500 do
      score =
        capacity([a, b, c, d], ingredients) * durability([a, b, c, d], ingredients) *
          flavor([a, b, c, d], ingredients) * texture([a, b, c, d], ingredients)

      {a, b, c, d, score}
    end
    |> Enum.max_by(fn {_, _, _, _, score} -> score end)
    |> elem(4)
  end

  def capacity(recipe, ingredients) do
    max(
      0,
      Enum.at(ingredients, 0).cap * Enum.at(recipe, 0) +
        Enum.at(ingredients, 1).cap * Enum.at(recipe, 1) +
        Enum.at(ingredients, 2).cap * Enum.at(recipe, 2) +
        Enum.at(ingredients, 3).cap * Enum.at(recipe, 3)
    )
  end

  def durability(recipe, ingredients) do
    max(
      0,
      Enum.at(ingredients, 0).dur * Enum.at(recipe, 0) +
        Enum.at(ingredients, 1).dur * Enum.at(recipe, 1) +
        Enum.at(ingredients, 2).dur * Enum.at(recipe, 2) +
        Enum.at(ingredients, 3).dur * Enum.at(recipe, 3)
    )
  end

  def flavor(recipe, ingredients) do
    max(
      0,
      Enum.at(ingredients, 0).fla * Enum.at(recipe, 0) +
        Enum.at(ingredients, 1).fla * Enum.at(recipe, 1) +
        Enum.at(ingredients, 2).fla * Enum.at(recipe, 2) +
        Enum.at(ingredients, 3).fla * Enum.at(recipe, 3)
    )
  end

  def texture(recipe, ingredients) do
    max(
      0,
      Enum.at(ingredients, 0).tex * Enum.at(recipe, 0) +
        Enum.at(ingredients, 1).tex * Enum.at(recipe, 1) +
        Enum.at(ingredients, 2).tex * Enum.at(recipe, 2) +
        Enum.at(ingredients, 3).tex * Enum.at(recipe, 3)
    )
  end

  def calories(recipe, ingredients) do
    max(
      0,
      Enum.at(ingredients, 0).cal * Enum.at(recipe, 0) +
        Enum.at(ingredients, 1).cal * Enum.at(recipe, 1) +
        Enum.at(ingredients, 2).cal * Enum.at(recipe, 2) +
        Enum.at(ingredients, 3).cal * Enum.at(recipe, 3)
    )
  end

  defp parse_ingredient(ingredient) do
    [_, name, cap, dur, fla, tex, cal] =
      Regex.run(
        ~r/([A-Za-z]+): capacity ([\d-]+), durability ([\d-]+), flavor ([\d-]+), texture ([\d-]+), calories ([\d-]+)/,
        ingredient
      )

    %{
      name: name,
      cap: String.to_integer(cap),
      dur: String.to_integer(dur),
      fla: String.to_integer(fla),
      tex: String.to_integer(tex),
      cal: String.to_integer(cal)
    }
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
