






if __name__ == '__main__':
    paths = [
        'Hotdog-not-hotdog/hotdog.jpg',
        'Hotdog-not-hotdog/maybe-hotdog.png',
        'Hotdog-not-hotdog/not-hotdog.jpg'
    ]

    for path in paths:
        check_whats_in_bun(CLIENT, path)
