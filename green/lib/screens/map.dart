import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';

class MapScreen extends StatefulWidget {
  const MapScreen({
    Key? key,
    this.location = const PlaceLocation(
      latitude: 14.599512,
      longitude: 120.984222,
      address: '',
    ),
    this.isSelecting = true,
  }) : super(key: key);

  final PlaceLocation location;
  final bool isSelecting;

  @override
  _MapScreenState createState() => _MapScreenState();
}

class _MapScreenState extends State<MapScreen> {
  LatLng? _pickedLocation;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.isSelecting ? 'Pick your Location' : 'Your Location'),
        actions: [
          if (widget.isSelecting)
            IconButton(
              icon: const Icon(Icons.save),
              onPressed: () {
                // Handle save action here
              },
            ),
        ],
      ),
      floatingActionButtonLocation: FloatingActionButtonLocation.centerFloat,
      floatingActionButton: FloatingActionButton.extended(
        backgroundColor: Theme.of(context).colorScheme.primary,
        onPressed: () {
          if (widget.isSelecting && _pickedLocation != null) {
            Navigator.of(context).pop(_pickedLocation);
          }
        },
        icon: const Icon(Icons.save),
        label: const Text('Save'),
      ),
      body: GoogleMap(
        onTap: !widget.isSelecting
            ? null
            : (position) {
          setState(() {
            _pickedLocation = position;
          });
        },
        initialCameraPosition: CameraPosition(
          target: LatLng(
            widget.location.latitude,
            widget.location.longitude,
          ),
          zoom: 16,
        ),
        markers: (_pickedLocation == null && widget.isSelecting)
            ? {}
            : {
          Marker(
            markerId: const MarkerId('m1'),
            position: _pickedLocation ??
                LatLng(
                  widget.location.latitude,
                  widget.location.longitude,
                ),
          ),
        },
      ),
    );
  }
}

class PlaceLocation {
  final double latitude;
  final double longitude;
  final String address;

  const PlaceLocation({
    required this.latitude,
    required this.longitude,
    required this.address,
  });
}
