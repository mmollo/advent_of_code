#include <stdio.h>
#include <stdlib.h>


struct node {
    int value;
    struct node* prev;
    struct node* next;
};

int main() {
    int nb_players = 423;
    int last_marble = 71944;
    
    int i,j, player_id;
    static unsigned long scores[423];

    struct node* current = (struct node*)malloc(sizeof(struct node));
    struct node* first = (struct node*)malloc(sizeof(struct node));
    struct node* second = (struct node*)malloc(sizeof(struct node));
    struct node* rem = (struct node*)malloc(sizeof(struct node));


    current->value = 0;
    current->prev = current;
    current->next = current;
    for(i = 0 ; i <= last_marble ; i++) {
        if(0 == i % 23) {
            player_id = i % nb_players;
            scores[player_id] += i;

            rem = current;
            for(j = 0 ; j < 7 ; j++) {
                rem = rem->prev;
            }
            scores[player_id] += rem->value;

            first = rem->prev;
            second = rem->next;
            first->next = second;
            second->prev = first;
            current = rem->next;

            continue;
        }

        struct node* marble = (struct node*)malloc(sizeof(struct node));
        marble->value = i;

        first = current->next;
        second = first->next;

        marble->prev = first;
        marble->next = second;

        first->next = marble;    
        second->prev = marble;

        current = marble;
    }

    unsigned long max = 0;
    for(i = 0 ; i < nb_players ; i++) {
        if(scores[i] > max) {
            max = scores[i];
        }
    }

    printf("%ld\n", max);
}