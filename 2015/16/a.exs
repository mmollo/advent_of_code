defmodule Sue do
  defstruct children: nil,
            cats: nil,
            samoyeds: nil,
            pomeranians: nil,
            akitas: nil,
            vizslas: nil,
            goldfish: nil,
            trees: nil,
            cars: nil,
            perfumes: nil
end

defmodule A do
  @goodSue %Sue{
    children: 3,
    cats: 7,
    samoyeds: 2,
    pomeranians: 3,
    akitas: 0,
    vizslas: 0,
    goldfish: 5,
    trees: 3,
    cars: 2,
    perfumes: 1
  }

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_sue/1)
  end

  def resolve(input) do
    input
    |> Enum.filter(fn {_id, sue} ->
      (sue.children == @goodSue.children || sue.children == nil) &&
        (sue.cats == @goodSue.cats || sue.cats == nil) &&
        (sue.samoyeds == @goodSue.samoyeds || sue.samoyeds == nil) &&
        (sue.pomeranians == @goodSue.pomeranians || sue.pomeranians == nil) &&
        (sue.akitas == @goodSue.akitas || sue.akitas == nil) &&
        (sue.vizslas == @goodSue.vizslas || sue.vizslas == nil) &&
        (sue.goldfish == @goodSue.goldfish || sue.goldfish == nil) &&
        (sue.trees == @goodSue.trees || sue.trees == nil) &&
        (sue.cars == @goodSue.cars || sue.cars == nil) &&
        (sue.perfumes == @goodSue.perfumes || sue.perfumes == nil)
    end)
    |> Enum.at(0)
    |> elem(0)
  end

  defp parse_sue(sue) do
    [id] = Regex.run(~r/^Sue ([\d]+):/, sue, capture: :all_but_first)

    sue =
      Regex.scan(~r/([a-z]+): ([\d]+)/, sue, capture: :all_but_first)
      |> Enum.reduce(%Sue{}, fn [prop, qty], acc ->
        Map.put(acc, String.to_atom(prop), String.to_integer(qty))
      end)

    {id, sue}
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
